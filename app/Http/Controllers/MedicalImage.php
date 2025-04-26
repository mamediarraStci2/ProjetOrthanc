<?php

namespace App\Http\Controllers;

use App\Models\MedicalImage;
use App\Services\OrthancService;
use Illuminate\Http\Request;

class MedicalImageController extends Controller
{
    protected $orthancService;

    public function __construct(OrthancService $orthancService)
    {
        $this->orthancService = $orthancService;
    }

    public function upload(Request $request)
    {
        $request->validate([
            'dicom' => 'required|file',
            'patient_id' => 'required|exists:patients,id',
            'consultation_id' => 'required|exists:consultations,id',
            'image_type' => 'required|string',
            'description' => 'nullable|string'
        ]);

        // Upload to Orthanc
        $result = $this->orthancService->uploadDicom($request->file('dicom')->path());
        
        if ($result) {
            // Save reference in database
            $image = MedicalImage::create([
                'patient_id' => $request->patient_id,
                'consultation_id' => $request->consultation_id,
                'orthanc_study_id' => $result->ID,
                'image_type' => $request->image_type,
                'description' => $request->description
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Image médicale téléversée avec succès',
                'image' => $image
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors du téléversement de l\'image'
        ], 500);
    }

    public function getPatientImages($patientId)
    {
        $images = MedicalImage::where('patient_id', $patientId)
            ->with('consultation')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($images as $image) {
            $orthancData = $this->orthancService->getStudies($image->orthanc_study_id);
            $image->orthanc_data = $orthancData;
        }

        return response()->json($images);
    }
}