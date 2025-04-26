<!-- En-tête avec bouton Nouveau Médecin -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Gestion des Médecins</h2>
    <button class="btn btn-primary" id="nouveau-medecin">
        <i class="fas fa-plus"></i> Nouveau Médecin
    </button>
</div>

<!-- Liste des médecins -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Spécialité</th>
                        <th>Hôpital</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($medecins ?? [] as $medecin)
                    <tr>
                        <td>{{ $medecin->nom }} {{ $medecin->prenom }}</td>
                        <td>{{ $medecin->specialite }}</td>
                        <td>{{ $medecin->hopital }}</td>
                        <td>{{ $medecin->email }}</td>
                        <td>{{ $medecin->telephone }}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info edit-medecin" data-id="{{ $medecin->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-medecin" data-id="{{ $medecin->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Aucun médecin enregistré</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Gestion du clic sur Nouveau Médecin
    $('#nouveau-medecin').click(function() {
        // Afficher le modal de création
        // TODO: Implémenter le formulaire de création
    });

    // Gestion du clic sur Modifier
    $('.edit-medecin').click(function() {
        var id = $(this).data('id');
        // TODO: Implémenter la modification
    });

    // Gestion du clic sur Supprimer
    $('.delete-medecin').click(function() {
        var id = $(this).data('id');
        if(confirm('Êtes-vous sûr de vouloir supprimer ce médecin ?')) {
            // TODO: Implémenter la suppression
        }
    });
});
</script> 