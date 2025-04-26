<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrthancService;
use Illuminate\Http\Response;

class DicomController extends Controller
{
    protected $orthancService;

    public function __construct(OrthancService $orthancService)
    {
        $this->orthancService = $orthancService;
    }

    public function show($instanceId)
    {
        try {
            $image = $this->orthancService->getInstance($instanceId);
            return response($image)
                ->header('Content-Type', 'application/octet-stream')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET')
                ->header('Access-Control-Allow-Headers', 'Content-Type')
                ->header('Content-Disposition', 'attachment; filename="image.dcm"');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Image DICOM non trouvée: ' . $e->getMessage()], 404);
        }
    }
}
