<?php

namespace App\Http\Controllers;

use App\Models\Dicom;
use App\Services\OrthancService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class DicomController extends Controller
{
    private $orthancService;

    public function __construct(OrthancService $orthancService)
    {
        $this->orthancService = $orthancService;
    }

    public function index()
    {
        try {
            $dicoms = Dicom::all();
            Log::info('Affichage de la liste des DICOMs', ['count' => $dicoms->count()]);
            return view('dicoms.index', compact('dicoms'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'affichage de la liste des DICOMs', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return view('dicoms.index', ['dicoms' => collect(), 'error' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:dcm'
        ]);

        try {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            
            Log::info('Début du processus d\'upload DICOM', [
                'filename' => $originalName,
                'size' => $file->getSize()
            ]);

            // Upload to Orthanc
            $orthancResponse = $this->orthancService->uploadDicom($file);
            
            Log::info('Réponse Orthanc reçue, sauvegarde en base de données', [
                'orthancResponse' => $orthancResponse
            ]);

            // Save to database
            $dicom = new Dicom();
            $dicom->filename = $originalName;
            $dicom->orthanc_id = $orthancResponse['ID'];
            $dicom->save();
            
            Log::info('DICOM sauvegardé avec succès', [
                'id' => $dicom->id,
                'filename' => $dicom->filename,
                'orthanc_id' => $dicom->orthanc_id
            ]);

            return redirect()->route('dicoms.index')
                ->with('success', 'Fichier DICOM uploadé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'upload du fichier DICOM', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'filename' => $request->hasFile('file') ? $request->file('file')->getClientOriginalName() : 'unknown'
            ]);

            return redirect()->route('dicoms.index')
                ->with('error', 'Erreur lors de l\'upload du fichier DICOM: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $dicom = Dicom::findOrFail($id);
            Log::info('Récupération du DICOM pour affichage', [
                'id' => $id,
                'filename' => $dicom->filename,
                'orthanc_id' => $dicom->orthanc_id
            ]);
            
            $imageData = $this->orthancService->getInstance($dicom->orthanc_id);
            
            Log::info('Image DICOM récupérée, envoi au navigateur');
            
            return response($imageData)
                ->header('Content-Type', 'image/png')
                ->header('Cache-Control', 'public, max-age=86400'); // Cache for 1 day
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'affichage du fichier DICOM', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Pour les requêtes AJAX ou les img src
            if (request()->expectsJson() || request()->wantsJson() || 
                request()->header('Accept') == 'image/png' || 
                strpos(request()->header('Accept'), 'image/') !== false) {
                
                // Générer une image d'erreur
                $img = imagecreate(400, 300);
                $bg = imagecolorallocate($img, 255, 0, 0);
                $textcolor = imagecolorallocate($img, 255, 255, 255);
                imagestring($img, 5, 50, 150, "Erreur: Impossible de charger l'image", $textcolor);
                
                ob_start();
                imagepng($img);
                $errorImage = ob_get_clean();
                imagedestroy($img);
                
                return response($errorImage)
                    ->header('Content-Type', 'image/png');
            }
            
            return response()->json([
                'error' => 'Erreur lors de l\'affichage du fichier DICOM: ' . $e->getMessage()
            ], 500);
        }
    }

    public function test()
    {
        try {
            $dicoms = Dicom::all();
            Log::info('Affichage de la page de test DICOM', ['count' => $dicoms->count()]);
            return view('dicoms.index', compact('dicoms'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'affichage de la page de test DICOM', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return view('dicoms.index', ['dicoms' => collect(), 'error' => $e->getMessage()]);
        }
    }

    /**
     * Vérifie si le serveur Orthanc est accessible
     * Cette route est utilisée comme proxy pour éviter les problèmes CORS
     */
    public function checkOrthancStatus()
    {
        try {
            // Utiliser le service OrthancService pour tester la connexion
            $client = new Client([
                'base_uri' => env('ORTHANC_API_URL', 'http://localhost:8042'),
                'auth' => [
                    env('ORTHANC_USERNAME', 'orthanc'),
                    env('ORTHANC_PASSWORD', 'orthanc')
                ],
                'verify' => false,
                'timeout' => 5,
            ]);
            
            $response = $client->get('/', [
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]);
            
            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);
            
            Log::info('Vérification du statut Orthanc', [
                'statusCode' => $statusCode, 
                'version' => $body['Version'] ?? 'unknown'
            ]);
            
            return response()->json([
                'status' => 'connected',
                'statusCode' => $statusCode,
                'version' => $body['Version'] ?? 'unknown',
                'name' => $body['Name'] ?? 'Orthanc Server'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la vérification du statut Orthanc', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Renvoie une image DICOM directement depuis Orthanc pour l'affichage dans la visionneuse
     */
    public function getDicomImage($orthancId)
    {
        try {
            Log::info('Récupération d\'image DICOM pour la visionneuse', [
                'orthancId' => $orthancId
            ]);
            
            $imageData = $this->orthancService->getInstance($orthancId);
            
            return response($imageData)
                ->header('Content-Type', 'image/png')
                ->header('Cache-Control', 'public, max-age=86400'); // Cache for 1 day
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération de l\'image DICOM', [
                'orthancId' => $orthancId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Impossible de récupérer l\'image DICOM: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Affiche une page de navigation dans les images DICOM d'Orthanc
     */
    public function orthancExplorer()
    {
        try {
            // Récupérer toutes les instances DICOM depuis Orthanc
            $client = new \GuzzleHttp\Client([
                'base_uri' => env('ORTHANC_API_URL', 'http://localhost:8042'),
                'auth' => [
                    env('ORTHANC_USERNAME', 'orthanc'),
                    env('ORTHANC_PASSWORD', 'orthanc')
                ],
                'verify' => false,
                'timeout' => 10,
            ]);
            
            // Récupérer la liste des instances
            $instancesResponse = $client->get('/instances', [
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]);
            $instances = json_decode($instancesResponse->getBody()->getContents(), true);
            
            // Récupérer les détails pour chaque instance
            $instancesDetails = [];
            foreach (array_slice($instances, 0, 30) as $instanceId) { // Limiter à 30 pour les performances
                try {
                    $detailsResponse = $client->get("/instances/{$instanceId}", [
                        'headers' => [
                            'Accept' => 'application/json'
                        ]
                    ]);
                    $details = json_decode($detailsResponse->getBody()->getContents(), true);
                    $instancesDetails[] = [
                        'id' => $instanceId,
                        'details' => $details
                    ];
                } catch (\Exception $e) {
                    Log::warning("Impossible de récupérer les détails de l'instance {$instanceId}: " . $e->getMessage());
                }
            }
            
            // Récupérer les dossiers médicaux qui ont des images DICOM
            $dossiersMedicaux = \App\Models\DossierMedical::whereNotNull('dicom_instance_id')->get();
            
            return view('dicoms.explorer', [
                'instances' => $instancesDetails,
                'orthancUrl' => env('ORTHANC_API_URL'),
                'dossiers' => $dossiersMedicaux
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des instances Orthanc', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('dicoms.explorer', [
                'error' => 'Impossible de se connecter à Orthanc: ' . $e->getMessage(),
                'instances' => [],
                'orthancUrl' => env('ORTHANC_API_URL'),
                'dossiers' => []
            ]);
        }
    }

    /**
     * Redirection vers Orthanc avec détermination du bon niveau (instance, série, étude)
     */
    public function redirectToOrthanc($instanceId)
    {
        try {
            Log::info('Début de la redirection vers Orthanc', ['instanceId' => $instanceId]);
            
            $client = new \GuzzleHttp\Client([
                'base_uri' => env('ORTHANC_API_URL', 'http://localhost:8042'),
                'auth' => [
                    env('ORTHANC_USERNAME', 'orthanc'),
                    env('ORTHANC_PASSWORD', 'orthanc')
                ],
                'verify' => false,
                'timeout' => 10,
            ]);
            
            // Récupérer les détails de l'instance
            Log::info('Récupération des détails de l\'instance');
            $response = $client->get("/instances/{$instanceId}", [
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]);
            
            $instanceData = json_decode($response->getBody()->getContents(), true);
            Log::info('Données de l\'instance récupérées', ['instanceData' => $instanceData]);
            
            // Récupérer l'ID de la série parente
            $parentSeriesId = $instanceData['ParentSeries'] ?? null;
            Log::info('ID de la série parent trouvé', ['parentSeriesId' => $parentSeriesId]);
            
            if ($parentSeriesId) {
                // Récupérer les détails de la série
                $seriesResponse = $client->get("/series/{$parentSeriesId}", [
                    'headers' => [
                        'Accept' => 'application/json'
                    ]
                ]);
                
                $seriesData = json_decode($seriesResponse->getBody()->getContents(), true);
                $studyId = $seriesData['ParentStudy'] ?? null;
                Log::info('ID de l\'étude trouvé', ['studyId' => $studyId]);
                
                if ($studyId) {
                    // Récupérer les détails de l'étude pour avoir le StudyInstanceUID
                    $studyResponse = $client->get("/studies/{$studyId}", [
                        'headers' => [
                            'Accept' => 'application/json'
                        ]
                    ]);
                    
                    $studyData = json_decode($studyResponse->getBody()->getContents(), true);
                    $mainDicomTags = $studyData['MainDicomTags'] ?? [];
                    $studyInstanceUID = $mainDicomTags['StudyInstanceUID'] ?? null;
                    
                    if ($studyInstanceUID) {
                        Log::info('StudyInstanceUID trouvé', ['studyInstanceUID' => $studyInstanceUID]);
                        $viewerUrl = env('ORTHANC_API_URL', 'http://localhost:8042') . "/stone-webviewer/index.html?study=" . $studyInstanceUID;
                        Log::info('Redirection vers', ['url' => $viewerUrl]);
                        return redirect($viewerUrl);
                    }
                }
            }
            
            Log::warning('Impossible de trouver le StudyInstanceUID');
            return back()->with('error', 'Impossible de trouver l\'identifiant de l\'étude.');
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la redirection vers Orthanc', [
                'instanceId' => $instanceId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Erreur lors de la redirection vers Orthanc: ' . $e->getMessage());
        }
    }

    public function getStudyIdFromInstance($instanceId)
    {
        try {
            Log::info('Début de la récupération de l\'ID de l\'étude', ['instanceId' => $instanceId]);
            
            $client = new Client([
                'base_uri' => env('ORTHANC_API_URL', 'http://localhost:8042'),
                'auth' => [
                    env('ORTHANC_USERNAME', 'orthanc'),
                    env('ORTHANC_PASSWORD', 'orthanc')
                ],
                'verify' => false,
                'timeout' => 5,
            ]);
            
            // Récupérer les détails de l'instance
            $response = $client->get("/instances/{$instanceId}", [
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]);
            
            $instanceData = json_decode($response->getBody()->getContents(), true);
            Log::info('Données de l\'instance récupérées', ['instanceData' => $instanceData]);
            
            // Récupérer l'ID de la série parente
            $parentSeriesId = $instanceData['ParentSeries'] ?? null;
            Log::info('ID de la série parente', ['parentSeriesId' => $parentSeriesId]);
            
            if ($parentSeriesId) {
                // Récupérer les détails de la série
                $seriesResponse = $client->get("/series/{$parentSeriesId}", [
                    'headers' => [
                        'Accept' => 'application/json'
                    ]
                ]);
                
                $seriesData = json_decode($seriesResponse->getBody()->getContents(), true);
                $studyId = $seriesData['ParentStudy'] ?? null;
                Log::info('ID de l\'étude trouvé', ['studyId' => $studyId]);
                
                return response()->json([
                    'success' => true,
                    'studyId' => $studyId
                ]);
            }
            
            Log::warning('Aucun ID d\'étude trouvé');
            return response()->json([
                'success' => false,
                'message' => 'Aucun ID d\'étude trouvé'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération de l\'ID de l\'étude', [
                'instanceId' => $instanceId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }
} 