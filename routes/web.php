<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecretaryController;    // Pour la recherche
use App\Http\Controllers\RendezVousController;  // Contrôleur RDV
use App\Http\Controllers\MedecinController; 
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Routes de l'Application
|--------------------------------------------------------------------------
*/

Route::middleware(['web'])->group(function () {
// Page d'accueil
Route::get('/', function () {
        return redirect()->route('login');
    });

// Routes pour la gestion des dossiers médicaux
Route::prefix('dossier-medical')->group(function () {
    Route::get('/create', [DossierMedicalController::class, 'create'])
         ->name('dossier_medical.create');
    Route::post('/', [DossierMedicalController::class, 'store'])
         ->name('dossier_medical.store');
    Route::get('/{id}', [DossierMedicalController::class, 'show'])
         ->name('dossier_medical.show');
});

// Route de recherche pour la secrétaire
Route::get('/secretary/search', [SecretaryController::class, 'search'])
     ->name('secretary.search');

// Dashboard — liste des rendez‑vous en cours
Route::get('/dashboard', [RendezVousController::class, 'index'])
     ->name('dashboard');

// Validation d'un rendez‑vous
Route::post('/rendezvous/{rendezVous}/valider', [RendezVousController::class, 'valider'])
     ->name('rendezvous.valider');

// Route pour le profil
Route::get('/profile', [ProfileController::class, 'index'])
     ->name('profile');

//pour le medecin
Route::resource('medecins', MedecinController::class);

// Routes médecin sans vérification de rôle pour le moment
Route::prefix('medecin')->name('medecin.')->group(function () {
    Route::get('/dashboard', [MedecinController::class, 'dashboard'])->name('dashboard');
    
    // Gestion des dossiers médicaux
    Route::get('/dossier/{patient}/edit', [MedecinController::class, 'editDossier'])->name('dossier.edit');
    Route::put('/dossier/{patient}', [MedecinController::class, 'updateDossier'])->name('dossier.update');
    
    // Gestion des rendez-vous
    Route::get('/rendez-vous/create/{patient}', [MedecinController::class, 'createRendezVous'])->name('rendez-vous.create');
    Route::post('/rendez-vous/{patient}', [MedecinController::class, 'storeRendezVous'])->name('rendez-vous.store');
    
    // Gestion des ordonnances
    Route::get('/ordonnance/create/{patient}', [MedecinController::class, 'createOrdonnance'])->name('ordonnance.create');
    Route::post('/ordonnance/{patient}', [MedecinController::class, 'storeOrdonnance'])->name('ordonnance.store');
});

//pour le patient - sans middleware pour l'instant
Route::prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/rendez-vous/create', [PatientDashboardController::class, 'demanderRendezVous'])->name('rendez-vous.create');
    Route::post('/rendez-vous', [PatientDashboardController::class, 'storeRendezVous'])->name('rendez-vous.store');
    Route::get('/ordonnances', [PatientDashboardController::class, 'voirOrdonnances'])->name('ordonnances.index');
});

// Routes pour les DICOMs (sans authentification pour les tests)
Route::get('/dicoms', [App\Http\Controllers\DicomController::class, 'index'])->name('dicoms.index');
Route::get('/dicoms/test', [App\Http\Controllers\DicomController::class, 'test'])->name('dicoms.test');
Route::post('/dicoms', [App\Http\Controllers\DicomController::class, 'store'])->name('dicoms.store');
Route::get('/dicoms/{id}', [App\Http\Controllers\DicomController::class, 'show'])->name('dicoms.show');
Route::get('/orthanc-status', [App\Http\Controllers\DicomController::class, 'checkOrthancStatus'])->name('orthanc.status');
Route::get('/orthanc-explorer', [App\Http\Controllers\DicomController::class, 'orthancExplorer'])->name('orthanc.explorer');
Route::get('/orthanc-redirect/{instanceId}', [App\Http\Controllers\DicomController::class, 'redirectToOrthanc'])->name('orthanc.redirect');

// Route API pour les images DICOM des dossiers médicaux
Route::get('/api/dicom/{orthancId}', [App\Http\Controllers\DicomController::class, 'getDicomImage'])->name('api.dicom.image');

    // Route API pour récupérer l'ID de l'étude à partir d'une instance DICOM
    Route::get('/api/dicom/{orthancId}/study', [App\Http\Controllers\DicomController::class, 'getStudyIdFromInstance'])->name('api.dicom.study');

    // Routes d'authentification
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Routes admin
    Route::middleware(['auth', \App\Http\Middleware\CheckRole::class.':admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');
        Route::resource('admin/medecins', MedecinController::class)->names('admin.medecins');
        Route::resource('admin/patients', PatientController::class)->names('admin.patients');
        Route::resource('admin/secretaires', SecretaryController::class)->names('admin.secretaires');
        Route::get('/admin/logs', [AdminController::class, 'logs'])->name('admin.logs.index');
        Route::resource('doctors', DoctorController::class);
        Route::resource('patients', PatientController::class);
        Route::resource('secretaries', SecretaryController::class);
    });
 });