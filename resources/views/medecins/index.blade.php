@extends('layouts.app')

@section('title', 'Gestion des Médecins')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary mb-0">Gestion des Médecins</h1>
        <a href="{{ route('medecins.create') }}" class="btn btn-primary">
            <i class="fas fa-user-md me-2"></i>Nouveau Médecin
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchMedecin" class="form-control" placeholder="Rechercher un médecin...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="filterSpecialite">
                        <option value="">Toutes les spécialités</option>
                        @foreach($specialites as $specialite)
                            <option value="{{ $specialite->id }}">{{ $specialite->libelle }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Spécialité</th>
                            <th>Hôpital</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($medecins as $medecin)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary-subtle rounded-circle me-2">
                                        <i class="fas fa-user-md text-primary"></i>
                                    </div>
                                    <div>
                                        <span class="fw-medium">{{ $medecin->utilisateur->nom }} {{ $medecin->utilisateur->prenom }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $medecin->specialite->libelle }}</td>
                            <td>{{ $medecin->hopital }}</td>
                            <td>{{ $medecin->utilisateur->email }}</td>
                            <td>{{ $medecin->utilisateur->telephone }}</td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('medecins.show', $medecin) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('medecins.edit', $medecin) }}" class="btn btn-sm btn-outline-secondary" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal{{ $medecin->id }}"
                                            title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Modal de suppression -->
                                <div class="modal fade" id="deleteModal{{ $medecin->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmer la suppression</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Êtes-vous sûr de vouloir supprimer le Dr. {{ $medecin->utilisateur->nom }} {{ $medecin->utilisateur->prenom }} ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <form action="{{ route('medecins.destroy', $medecin) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-user-md fa-2x mb-3 d-block"></i>
                                Aucun médecin enregistré
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Total : {{ $medecins->total() }} médecin(s)
                </div>
                {{ $medecins->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .table th {
        font-weight: 600;
        color: #4a5568;
    }
    .table td {
        vertical-align: middle;
    }
    .btn-group > .btn {
        padding: .25rem .5rem;
    }
</style>
@endpush

@push('scripts')
<script>
document.getElementById('searchMedecin').addEventListener('keyup', function(e) {
    // Implémenter la recherche en temps réel
});

document.getElementById('filterSpecialite').addEventListener('change', function(e) {
    // Implémenter le filtrage par spécialité
});
</script>
@endpush
@endsection