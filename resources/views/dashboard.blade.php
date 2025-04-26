@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
  <h1 class="mb-4">Tableau de bord</h1>
  
  <div class="row g-4">
    <!-- Carte Statistiques Patients -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="card-title">Statistiques des Patients</h5>
        </div>
        <div class="card-body">
          <p class="card-text">Nombre total de patients : <strong>125</strong></p>
          <p class="card-text">Patients actifs aujourd'hui : <strong>50</strong></p>
          <!-- Vous pouvez ajouter des graphiques ou d'autres statistiques ici -->
        </div>
      </div>
    </div>

    <!-- Carte Statistiques Dossiers Médicaux -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
          <h5 class="card-title">Statistiques des Dossiers Médicaux</h5>
        </div>
        <div class="card-body">
          <p class="card-text">Nombre total de dossiers médicaux : <strong>200</strong></p>
          <p class="card-text">Dossiers mis à jour aujourd'hui : <strong>15</strong></p>
          <!-- Ajoutez d'autres indicateurs ou graphiques -->
        </div>
      </div>
    </div>
  </div>

  <!-- Autres sections du dashboard -->
  <div class="row g-4 mt-4">
    <!-- Exemple : activités récentes -->
    <div class="col-md-12">
      <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
          <h5 class="card-title">Activités Récentes</h5>
        </div>
        <div class="card-body">
          <ul class="list-group">
            <li class="list-group-item">Dossier médical créé pour <strong>John Doe</strong> – 10 min</li>
            <li class="list-group-item">Mise à jour du dossier de <strong>Jane Doe</strong> – 20 min</li>
            <li class="list-group-item">Suppression du dossier de <strong>Alex Smith</strong> – 30 min</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
