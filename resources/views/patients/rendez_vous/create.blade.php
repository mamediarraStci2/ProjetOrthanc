@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Demander un rendez-vous</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('patient.rendez-vous.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="medecin_id" class="form-label">Médecin</label>
                            <select name="medecin_id" id="medecin_id" class="form-select @error('medecin_id') is-invalid @enderror" required>
                                <option value="">Choisir un médecin</option>
                                @foreach($medecins as $medecin)
                                    <option value="{{ $medecin->id }}">
                                        Dr. {{ $medecin->utilisateur->name }} - {{ $medecin->specialite->libelle }}
                                    </option>
                                @endforeach
                            </select>
                            @error('medecin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date_heure" class="form-label">Date et heure</label>
                            <input type="datetime-local" class="form-control @error('date_heure') is-invalid @enderror" 
                                   id="date_heure" name="date_heure" required>
                            @error('date_heure')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="motif" class="form-label">Motif de la consultation</label>
                            <textarea class="form-control @error('motif') is-invalid @enderror" 
                                      id="motif" name="motif" rows="3" required></textarea>
                            @error('motif')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Demander le rendez-vous
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection