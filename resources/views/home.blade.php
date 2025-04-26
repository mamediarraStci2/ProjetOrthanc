@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <!-- Carte de bienvenue -->
      <div class="card shadow-lg mb-4">
        <div class="card-header bg-primary text-white">
          <h2>Bienvenue sur votre espace secrétaire</h2>
        </div>
        <div class="card-body">
          <p>
            Cet espace vous permet de gérer les dossiers médicaux, consulter les rendez-vous et accéder aux informations et ressources de la plateforme.
          </p>
        </div>
      </div>

      <!-- Carte Politiques de Sécurité -->
      <div class="card shadow-lg mb-4">
        <div class="card-header bg-danger text-white">
          <h3>Politiques de sécurité</h3>
        </div>
        <div class="card-body">
          <ul>
            <li>Utilisez des mots de passe complexes et changez-les régulièrement.</li>
            <li>Ne partagez jamais vos identifiants et ne les notez pas en clair.</li>
            <li>Surveillez régulièrement les accès et signalez toute activité suspecte.</li>
            <li>Protégez les données patient conformément aux réglementations en vigueur.</li>
            <li>Utilisez des connexions sécurisées (HTTPS) lors de l'accès à la plateforme.</li>
          </ul>
          <p>
            Pour consulter l'intégralité des politiques de sécurité, cliquez sur 
            <a href="#" class="text-decoration-underline">ce lien</a>.
          </p>
        </div>
      </div>

      <!-- Carte Informations Pertinentes -->
      <div class="card shadow-lg mb-4">
        <div class="card-header bg-secondary text-white">
          <h3>Informations Pertinentes</h3>
        </div>
        <div class="card-body">
          <p>
            Veuillez respecter strictement les procédures opérationnelles relatives à l'accès aux dossiers médicaux.
          </p>
          <p>
            Restez informée des dernières mises à jour du système, des changements réglementaires et des consignes du service informatique.
          </p>
          <p>
            Pour toute question concernant ces procédures, contactez le service informatique.
          </p>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
