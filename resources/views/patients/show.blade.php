@extends('layouts.app')

@section('title', 'Détails du Patient')

@section('content')
<div class="container">
    <h1 class="mb-4">Détails du Patient</h1>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            Patient: {{ $patient->nom }} {{ $patient->prenom }}
        </div>
        <div class="card-body">
            <p><strong>NNS:</strong> {{ $patient->nss }}</p>
            <p><strong>Date de naissance:</strong> {{ $patient->date_naissance }}</p>
            <p><strong>Lieu de naissance:</strong> {{ $patient->lieu_naissance }}</p>
            <p><strong>Informations complémentaires:</strong></p>
            <p>{{ $patient->informations ?? 'Aucune information supplémentaire.' }}</p>
        </div>
    </div>

    <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning mt-3">Modifier</a>
    <a href="{{ route('patients.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection
