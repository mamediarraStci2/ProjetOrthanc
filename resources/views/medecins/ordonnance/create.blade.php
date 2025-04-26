@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Nouvelle ordonnance pour {{ $patient->nom }} {{ $patient->prenom }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('ordonnance.store', $patient->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div id="medicaments">
                            <div class="medicament-item border rounded p-3 mb-3">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Médicament</label>
                                        <input type="text" class="form-control" name="medicaments[]" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Posologie</label>
                                        <input type="text" class="form-control" name="posologies[]" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Durée</label>
                                        <input type="text" class="form-control" name="durees[]" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-secondary mb-3" onclick="ajouterMedicament()">
                            <i class="bi bi-plus-circle me-1"></i>Ajouter un médicament
                        </button>

                        <div class="mb-3">
                            <label class="form-label">Instructions particulières</label>
                            <textarea class="form-control" name="instructions" rows="3"></textarea>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary me-2">Annuler</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-file-earmark-text me-1"></i>Générer l'ordonnance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function ajouterMedicament() {
    const template = `
        <div class="medicament-item border rounded p-3 mb-3">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="form-label">Médicament</label>
                    <input type="text" class="form-control" name="medicaments[]" required>
                </div>
                <div class="col-md-3 mb-2">
                    <label class="form-label">Posologie</label>
                    <input type="text" class="form-control" name="posologies[]" required>
                </div>
                <div class="col-md-3 mb-2">
                    <label class="form-label">Durée</label>
                    <input type="text" class="form-control" name="durees[]" required>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="this.closest('.medicament-item').remove()">
                <i class="bi bi-trash"></i> Supprimer
            </button>
        </div>
    `;
    document.getElementById('medicaments').insertAdjacentHTML('beforeend', template);
}
</script>
@endpush
@endsection