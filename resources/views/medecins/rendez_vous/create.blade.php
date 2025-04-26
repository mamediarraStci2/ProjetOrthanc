@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Nouveau rendez-vous pour {{ $patient->nom }} {{ $patient->prenom }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('medecin.rendez-vous.store', $patient->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="date" class="form-label">Date du rendez-vous</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>

                        <div class="mb-3">
                            <label for="heure" class="form-label">Heure du rendez-vous</label>
                            <input type="time" class="form-control" id="heure" name="heure" required>
                        </div>

                        <div class="mb-3">
                            <label for="motif" class="form-label">Motif du rendez-vous</label>
                            <textarea class="form-control" id="motif" name="motif" rows="3" required></textarea>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('medecin.dashboard') }}" class="btn btn-outline-secondary me-2">Annuler</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-calendar-check me-1"></i>Programmer le rendez-vous
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection