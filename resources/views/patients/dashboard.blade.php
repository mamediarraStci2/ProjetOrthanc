@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Mes Rendez-vous</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0">Aucun rendez-vous prévu</p>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('patient.rendez-vous.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i>Demander un rendez-vous
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Mon Dossier Médical</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Les informations de votre dossier médical seront affichées ici.</p>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Mes Ordonnances</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Vos ordonnances seront affichées ici.</p>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('patient.ordonnances.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-file-text me-1"></i>Voir toutes mes ordonnances
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection