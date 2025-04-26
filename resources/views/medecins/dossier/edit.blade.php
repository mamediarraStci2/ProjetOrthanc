@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Dossier médical - {{ $patient->nom }} {{ $patient->prenom }}</h5>
                    <span class="badge bg-info">Né(e) le {{ $patient->date_naissance }}</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('medecin.dossier.update', $patient->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6>Antécédents médicaux</h6>
                                <textarea name="antecedents" class="form-control" rows="4">{{ $dossier->antecedents ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <h6>Allergies</h6>
                                <textarea name="allergies" class="form-control" rows="4">{{ $dossier->allergies ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h6>Notes de consultation</h6>
                                <textarea name="notes" class="form-control" rows="6">{{ $dossier->notes ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('medecin.dashboard') }}" class="btn btn-outline-secondary me-2">Retour</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection