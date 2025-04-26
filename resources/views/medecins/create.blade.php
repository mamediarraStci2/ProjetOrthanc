@extends('layouts.app')

@section('title', 'Ajouter un Médecin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-person-plus-fill me-2"></i>Ajouter un Nouveau Médecin
                    </h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('medecins.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- Informations de l'utilisateur -->
                        <div class="mb-4">
                            <h5 class="text-muted mb-3">Informations Personnelles</h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label">Nom</label>
                                    <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                           id="nom" name="nom" value="{{ old('nom') }}" required>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="prenom" class="form-label">Prénom</label>
                                    <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                                           id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                                    @error('prenom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control @error('telephone') is-invalid @enderror" 
                                           id="telephone" name="telephone" value="{{ old('telephone') }}" required>
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informations professionnelles -->
                        <div class="mb-4">
                            <h5 class="text-muted mb-3">Informations Professionnelles</h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="specialite_medicale_id" class="form-label">Spécialité</label>
                                    <select class="form-select @error('specialite_medicale_id') is-invalid @enderror" 
                                            id="specialite_medicale_id" name="specialite_medicale_id" required>
                                        <option value="">Sélectionner une spécialité</option>
                                        @foreach($specialites as $specialite)
                                            <option value="{{ $specialite->id }}" 
                                                {{ old('specialite_medicale_id') == $specialite->id ? 'selected' : '' }}>
                                                {{ $specialite->libelle }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('specialite_medicale_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="hopital" class="form-label">Hôpital/Clinique</label>
                                    <input type="text" class="form-control @error('hopital') is-invalid @enderror" 
                                           id="hopital" name="hopital" value="{{ old('hopital') }}" required>
                                    @error('hopital')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('medecins.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Validation côté client
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>
@endpush