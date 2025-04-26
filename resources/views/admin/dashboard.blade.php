@extends('layouts.admin')

@section('styles')
<style>
    .sidebar {
        min-height: 100vh;
        background-color: #343a40;
        padding-top: 20px;
    }
    .sidebar .nav-link {
        color: #fff;
        padding: 10px 20px;
    }
    .sidebar .nav-link:hover {
        background-color: #495057;
    }
    .sidebar .nav-link i {
        margin-right: 10px;
    }
    .main-content {
        padding: 20px;
    }
    .search-section {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Dashboard Content -->
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Patients</h6>
                            <h2 class="mt-2 mb-0">{{ $stats['patients'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Médecins</h6>
                            <h2 class="mt-2 mb-0">{{ $stats['medecins'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-user-md fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Secrétaires</h6>
                            <h2 class="mt-2 mb-0">{{ $stats['secretaires'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-user-nurse fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">RDV Aujourd'hui</h6>
                            <h2 class="mt-2 mb-0">{{ $stats['rendezVous'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-calendar-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Derniers Rendez-vous -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Derniers Rendez-vous</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Médecin</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAppointments ?? [] as $appointment)
                                <tr>
                                    <td>{{ $appointment->patient->nom }}</td>
                                    <td>{{ $appointment->medecin->nom }}</td>
                                    <td>{{ $appointment->date_heure->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->is_validated ? 'success' : 'warning' }}">
                                            {{ $appointment->is_validated ? 'Validé' : 'En attente' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucun rendez-vous récent</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dernières Connexions -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Dernières Connexions</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Rôle</th>
                                    <th>Date</th>
                                    <th>IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentLogins ?? [] as $login)
                                <tr>
                                    <td>{{ $login->user->name }}</td>
                                    <td>{{ ucfirst($login->user->role) }}</td>
                                    <td>{{ $login->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $login->ip_address }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucune connexion récente</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add any JavaScript needed for the dashboard
    $(document).ready(function() {
        // Handle search form submission with AJAX
        $('form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'GET',
                data: $(this).serialize(),
                success: function(response) {
                    $('#searchResults').html(response);
                }
            });
        });
    });

    // Rafraîchissement automatique des données toutes les 5 minutes
    setInterval(function() {
        window.location.reload();
    }, 300000);
</script>
@endsection 