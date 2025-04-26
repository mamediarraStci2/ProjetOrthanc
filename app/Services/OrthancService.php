<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OrthancService
{
    private $client;
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('ORTHANC_API_URL', 'http://localhost:8042');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'auth' => [
                env('ORTHANC_USERNAME', 'orthanc'),
                env('ORTHANC_PASSWORD', 'orthanc')
            ],
            'verify' => false // Désactiver la vérification SSL pour le développement local
        ]);
    }

    public function getPatients()
    {
        try {
            $response = $this->client->get('/patients');
            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            Log::error('Error getting patients from Orthanc: ' . $e->getMessage());
            return null;
        }
    }

    public function getStudies($patientId)
    {
        try {
            $response = $this->client->get("/patients/{$patientId}/studies");
            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            Log::error('Error getting studies from Orthanc: ' . $e->getMessage());
            return null;
        }
    }

    public function uploadDicom($file)
    {
        try {
            $filepath = $file->getPathname();
            $filename = $file->getClientOriginalName();
            
            Log::info('Tentative d\'upload DICOM vers Orthanc', [
                'filename' => $filename,
                'filesize' => filesize($filepath),
                'filepath' => $filepath,
                'url' => $this->baseUrl . '/instances'
            ]);
            
            $response = $this->client->post('/instances', [
                'headers' => [
                    'Content-Type' => 'application/dicom'
                ],
                'body' => fopen($filepath, 'r'),
                'timeout' => 60, // Augmenter le timeout pour les gros fichiers
            ]);

            $statusCode = $response->getStatusCode();
            Log::info("Réponse d'upload reçue avec code: {$statusCode}");
            
            $data = json_decode($response->getBody(), true);
            Log::info('Upload DICOM réussi', [
                'response' => $data,
                'statusCode' => $statusCode
            ]);
            
            return $data;
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'upload DICOM vers Orthanc', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function getInstance($instanceId)
    {
        try {
            Log::info('Tentative de récupération de l\'instance DICOM', [
                'instanceId' => $instanceId,
                'baseUrl' => $this->baseUrl
            ]);

            // Récupérer directement le rendu PNG de l'image
            $url = "/instances/{$instanceId}/preview";
            Log::info("URL de requête: {$this->baseUrl}{$url}");
            
            $response = $this->client->get($url, [
                'headers' => [
                    'Accept' => 'image/png'
                ],
                'timeout' => 30, // Augmenter le timeout pour les grandes images
            ]);
            
            $statusCode = $response->getStatusCode();
            Log::info("Réponse reçue avec code: {$statusCode}");
            
            if ($statusCode !== 200) {
                Log::error("Erreur de réponse Orthanc: {$statusCode}");
                throw new \Exception("Erreur de réponse Orthanc: {$statusCode}");
            }
            
            Log::info('Image preview récupérée avec succès', [
                'contentType' => $response->getHeaderLine('Content-Type'),
                'contentLength' => $response->getHeaderLine('Content-Length')
            ]);
            
            return $response->getBody();
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération de l\'instance DICOM', [
                'instanceId' => $instanceId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}