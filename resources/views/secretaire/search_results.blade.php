@extends('layouts.app')

@section('title', 'Résultats de recherche')

@section('content')
<div class="container my-4">
  <h2>Résultats de Recherche</h2>
  @if($results->isEmpty())
    <div class="alert alert-warning">
      Aucun dossier médical trouvé.
    </div>
  @else
    <div class="list-group">
      @foreach($results as $dossier)
        <a href="{{ route('dossier_medical.show', $dossier->id) }}" class="list-group-item list-group-item-action">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{ $dossier->nns }}</h5>
            <small>{{ $dossier->updated_at->diffForHumans() }}</small>
          </div>
          <p class="mb-1">{{ $dossier->nom }} {{ $dossier->prenom }}</p>
          <small>Date de naissance: {{ \Carbon\Carbon::parse($dossier->date_naissance)->format('d/m/Y') }}</small>
        </a>
      @endforeach
    </div>
  @endif
  
  <a href="{{ route('home') }}" class="btn btn-secondary mt-4">Retour à l'accueil</a>
</div>
@endsection
