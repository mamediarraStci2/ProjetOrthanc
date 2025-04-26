@forelse($results as $dossier)
<tr>
    <td>{{ $dossier->id }}</td>
    <td>{{ $dossier->nns }}</td>
    <td>{{ $dossier->nin }}</td>
    <td>{{ $dossier->num_extrait_naissance }}</td>
    <td>{{ $dossier->nom }}</td>
    <td>{{ $dossier->prenom }}</td>
    <td>
        <div class="btn-group">
            <a href="{{ route('admin.dossiers.show', $dossier->id) }}" class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('admin.dossiers.edit', $dossier->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i>
            </a>
            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $dossier->id }})">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center">Aucun résultat trouvé</td>
</tr>
@endforelse 