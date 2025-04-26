@extends('layouts.app')

@section('title', 'Interface Secrétaire')

@section('content')
<div class="container">
  <h1 class="mb-4">Bonjour, Secrétaire Médicale</h1>
  
  <!-- Barre de recherche -->
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
      <h4>Rechercher un dossier médical</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('secretary.search') }}" method="GET" class="row g-3 align-items-end">
        <div class="col-md-8">
          <input type="text" name="query" class="form-control" placeholder="Saisissez votre recherche..." required>
        </div>
        <div class="col-md-4">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="criteria[]" value="nns" id="critNNS">
            <label class="form-check-label" for="critNNS">NNS</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="criteria[]" value="nin" id="critNIN">
            <label class="form-check-label" for="critNIN">NIN</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="criteria[]" value="extrait" id="critExtrait">
            <label class="form-check-label" for="critExtrait">Extrait naissance</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="criteria[]" value="nomprenom" id="critNomPrenom">
            <label class="form-check-label" for="critNomPrenom">Nom & Prénom</label>
          </div>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Rechercher</button>
          <a href="{{ route('dossier_medical.create') }}" class="btn btn-success">Créer un nouveau dossier médical</a>
        </div>
      </form>
    </div>
  </div>
  
  <!-- Dossiers récents affichés horizontalement -->
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
      <h4>Dossiers Médicaux Récents</h4>
    </div>
    <div class="card-body">
      @if($recentDossiers->isEmpty())
        <p>Aucun dossier récent à afficher.</p>
      @else
        <div class="d-flex flex-wrap gap-3">
          @foreach($recentDossiers as $dossier)
            <div class="card" style="min-width: 18rem;">
              <div class="card-body">
                <h5 class="card-title">{{ $dossier->nns }}</h5>
                <p class="card-text">{{ $dossier->nom }} {{ $dossier->prenom }}</p>
                <p class="card-text"><small class="text-muted">{{ $dossier->date_naissance }}</small></p>
                <a href="{{ route('dossier_medical.show', $dossier->id) }}" class="btn btn-outline-primary btn-sm">Détails</a>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
  
  <!-- Liste des rendez-vous -->
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
      <h4>Liste des Rendez-Vous</h4>
    </div>
    <div class="card-body">
      @if($appointments->isEmpty())
        <p>Aucun rendez-vous prévu.</p>
      @else
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Patient</th>
              <th>Date & Heure</th>
              <th>État</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($appointments as $rdv)
              <tr>
                <td>{{ $rdv->patient->nom ?? '-' }} {{ $rdv->patient->prenom ?? '' }}</td>
                <td>{{ $rdv->date_heure }}</td>
                <td>{{ $rdv->etat ?? 'Non défini' }}</td>
                <td><a href="#" class="btn btn-sm btn-info">Détails</a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
</div>
@endsection
