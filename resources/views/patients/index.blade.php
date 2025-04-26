@extends('layouts.app')

@section('title', 'Liste des Patients')

@section('content')
<div class="container">
    <h1 class="mb-4">Liste des Patients</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('patients.create') }}" class="btn btn-primary mb-3">Ajouter un Patient</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NNS</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de naissance</th>
                <th>Lieu de naissance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->nss }}</td>
                <td>{{ $patient->nom }}</td>
                <td>{{ $patient->prenom }}</td>
                <td>{{ $patient->date_naissance }}</td>
                <td>{{ $patient->lieu_naissance }}</td>
                <td>
                    <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info btn-sm">Voir</a>
                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce patient ?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $patients->links() }}
</div>
@endsection
