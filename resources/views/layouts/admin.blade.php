<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Administration</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
            position: fixed;
            width: inherit;
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 10px 20px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .main-content {
            margin-left: 16.666667%;
            padding: 20px;
        }
        .search-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        #dynamic-content {
            margin-top: 20px;
        }
        .stats-container {
            margin-bottom: 20px;
        }
        .tables-container {
            margin-top: 20px;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="text-white p-3">
                    <h4>Administration</h4>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link" href="#" data-section="dashboard" data-url="{{ route('admin.dashboard') }}" id="dashboard-link">
                        <i class="fas fa-home"></i> Tableau de bord
                    </a>
                    <a class="nav-link" href="#" data-section="medecins" data-url="{{ route('admin.medecins.index') }}" id="medecins-link">
                        <i class="fas fa-user-md"></i> Médecins
                    </a>
                    <a class="nav-link" href="#" data-section="patients" data-url="{{ route('admin.patients.index') }}" id="patients-link">
                        <i class="fas fa-users"></i> Patients
                    </a>
                    <a class="nav-link" href="#" data-section="secretaires" data-url="{{ route('admin.secretaires.index') }}" id="secretaires-link">
                        <i class="fas fa-user-nurse"></i> Secrétaires
                    </a>
                    <a class="nav-link" href="#" data-section="logs" data-url="{{ route('admin.logs.index') }}" id="logs-link">
                        <i class="fas fa-history"></i> Logs
                    </a>
                </nav>
                <div class="mt-auto p-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <!-- Search Box -->
                <div class="search-box">
                    <form action="{{ route('admin.search') }}" method="GET" id="searchForm">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="query" class="form-control" placeholder="Rechercher...">
                            </div>
                            <div class="col-md-4">
                                <div class="btn-group" role="group">
                                    <input type="checkbox" class="btn-check" name="criteria[]" value="nns" id="nns">
                                    <label class="btn btn-outline-primary" for="nns">NNS</label>

                                    <input type="checkbox" class="btn-check" name="criteria[]" value="nin" id="nin">
                                    <label class="btn btn-outline-primary" for="nin">NIN</label>

                                    <input type="checkbox" class="btn-check" name="criteria[]" value="extrait" id="extrait">
                                    <label class="btn btn-outline-primary" for="extrait">N° Extrait</label>

                                    <input type="checkbox" class="btn-check" name="criteria[]" value="nomprenom" id="nomprenom">
                                    <label class="btn btn-outline-primary" for="nomprenom">Nom/Prénom</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Rechercher
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Stats Container -->
                <div class="stats-container">
                    @include('admin.partials.stats')
                </div>

                <!-- Dynamic Content Container -->
                <div id="section-content">
                    <!-- Le contenu de la section sera chargé ici -->
                </div>

                <!-- Tables Container -->
                <div class="tables-container">
                    @include('admin.partials.tables')
                </div>

                <!-- Footer -->
                @if(!Route::is('login'))
                <footer class="bg-gray-800 text-white py-4 mt-8">
                    <div class="container mx-auto px-4 text-center">
                        <p>&copy; {{ date('Y') }} Sénégal Care. Tous droits réservés.</p>
                    </div>
                </footer>
                @endif
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fonction pour mettre à jour l'état actif des liens
            function updateActiveLink(section) {
                $('.sidebar .nav-link').removeClass('active');
                $('#' + section + '-link').addClass('active');
                localStorage.setItem('activeSection', section);
            }

            // Fonction pour charger le contenu d'une section
            function loadSectionContent(url, section) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        // Mettre à jour l'URL sans recharger la page
                        history.pushState({}, '', url);
                        
                        // Mettre à jour le contenu de la section
                        $('#section-content').html(response);
                        
                        // Mettre à jour le lien actif
                        updateActiveLink(section);
                    }
                });
            }

            // Restaurer l'état actif au chargement de la page
            var currentPath = window.location.pathname;
            var section = currentPath.split('/').pop();
            if (section === 'dashboard' || section === '') {
                updateActiveLink('dashboard');
            } else {
                updateActiveLink(section);
            }

            // Gestion des clics sur les liens du sidebar
            $('.sidebar .nav-link').click(function(e) {
                e.preventDefault();
                var section = $(this).data('section');
                var url = $(this).data('url');
                loadSectionContent(url, section);
            });

            // Gestion de la recherche
            $('#searchForm').on('submit', function(e) {
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

            // Gestion du bouton retour du navigateur
            window.onpopstate = function(event) {
                var currentPath = window.location.pathname;
                var section = currentPath.split('/').pop();
                if (section === 'dashboard' || section === '') {
                    updateActiveLink('dashboard');
                } else {
                    updateActiveLink(section);
                }
                location.reload();
            };
        });
    </script>
    @yield('scripts')
</body>
</html> 