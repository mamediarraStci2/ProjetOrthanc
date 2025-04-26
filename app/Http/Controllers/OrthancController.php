<?php

namespace App\Http\Controllers;

use App\Services\OrthancService;
use Illuminate\Http\Request;

class OrthancController extends Controller
{
    protected $orthancService;

    public function __construct(OrthancService $orthancService)
    {
        $this->orthancService = $orthancService;
    }

    public function getPatients()
    {
        return response()->json($this->orthancService->getPatients());
    }

    public function getStudies($patientId)
    {
        return response()->json($this->orthancService->getStudies($patientId));
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('dicom')) {
            $path = $request->file('dicom')->path();
            return response()->json($this->orthancService->uploadDicom($path));
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}