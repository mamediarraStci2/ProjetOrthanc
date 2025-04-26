@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($appointments->isEmpty())
        <div class="alert alert-info">
            Aucun rendez‑vous en cours.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Date & heure</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $index => $rdv)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $rdv->patient_name ?? 'N/A' }}</td>
                            <td>{{ $rdv->date }} à {{ $rdv->heure }}</td>
                            <td>
                                @if ($rdv->is_validated)
                                    <span class="badge bg-success">Validé</span>
                                @else
                                    <span class="badge bg-warning text-dark">En attente</span>
                                @endif
                            </td>
                            <td>
                                <!-- Ajoute ici les boutons Modifier/Supprimer -->
                                <a href="#" class="btn btn-sm btn-primary">Voir</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $appointments->links() }}
            </div>
        </div>
    @endif

</div>
@endsection
