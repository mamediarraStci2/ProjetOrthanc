@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Liste des patients -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Liste des Patients</h5>
                    <div class="input-group w-50">
                        <input type="text" class="form-control" placeholder="Rechercher un patient...">
                        <button class="btn btn-outline-primary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Date de naissance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patients as $patient)
                                <tr>
                                    <td>{{ $patient->nom }}</td>
                                    <td>{{ $patient->prenom }}</td>
                                    <td>{{ $patient->date_naissance }}</td>
                                    <td>
                                        <a href="{{ route('medecin.dossier-medical.edit', $patient->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-folder"></i> Dossier
                                        </a>
                                        <a href="{{ route('medecin.rendez-vous.create', $patient->id) }}" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-calendar-plus"></i> RDV
                                        </a>
                                        <a href="{{ route('medecin.ordonnance-medical.create', $patient->id) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-file-text"></i> Ordonnance
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rendez-vous du jour -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Rendez-vous du jour</h5>
                </div>
                <div class="card-body">
                    @if($rendezVous->count() > 0)
                        @foreach($rendezVous as $rdv)
                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                            <div class="me-3">
                                <span class="badge bg-primary">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}</span>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $rdv->patient->nom }} {{ $rdv->patient->prenom }}</h6>
                                <small class="text-muted">{{ $rdv->sujet }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">Aucun rendez-vous aujourd'hui</p>
                    @endif
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Statistiques</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Patients du jour</span>
                        <span class="badge bg-info">{{ $statsJour['patients'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Consultations en attente</span>
                        <span class="badge bg-warning">{{ $statsJour['attente'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Imagerie Médicale -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Imagerie Médicale</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('medical-images.upload') }}" method="POST" enctype="multipart/form-data" class="mb-3">
                        @csrf
                        <input type="hidden" name="patient_id" id="selected_patient_id">
                        <input type="hidden" name="consultation_id" id="selected_consultation_id">
                        
                        <div class="mb-3">
                            <label for="dicom_file" class="form-label">Fichier DICOM</label>
                            <input type="file" class="form-control" id="dicom_file" name="dicom" accept=".dcm">
                        </div>
                        
                        <div class="mb-3">
                            <label for="image_type" class="form-label">Type d'image</label>
                            <select class="form-select" id="image_type" name="image_type" required>
                                <option value="radiographie">Radiographie</option>
                                <option value="scanner">Scanner</option>
                                <option value="irm">IRM</option>
                                <option value="echographie">Échographie</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Téléverser l'image</button>
                    </form>

                    <div id="patient_images">
                        <!-- Les images du patient seront chargées ici dynamiquement -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection