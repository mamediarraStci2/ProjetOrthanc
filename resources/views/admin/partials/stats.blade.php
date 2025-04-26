<!-- Statistiques -->
<div class="row">
    <div class="col-md-3">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <h5 class="card-title">Total Médecins</h5>
                <h2 class="mb-0">{{ $totalMedecins ?? 0 }}</h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">Voir détails</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <h5 class="card-title">Total Patients</h5>
                <h2 class="mb-0">{{ $totalPatients ?? 0 }}</h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">Voir détails</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                <h5 class="card-title">Total Secrétaires</h5>
                <h2 class="mb-0">{{ $totalSecretaires ?? 0 }}</h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">Voir détails</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">
                <h5 class="card-title">Total Rendez-vous</h5>
                <h2 class="mb-0">{{ $totalRendezVous ?? 0 }}</h2>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">Voir détails</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div> 