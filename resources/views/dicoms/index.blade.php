@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Liste des fichiers DICOM</h1>

    <div class="alert alert-info">
        <strong>Statut Orthanc:</strong> 
        <span id="orthanc-status">Vérification...</span>
    </div>

    @if(isset($error))
        <div class="alert alert-danger">
            <strong>Erreur:</strong> {{ $error }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-4">
        <form action="{{ route('dicoms.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf
            <div class="col-auto">
                <input type="file" name="file" class="form-control" accept=".dcm">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Uploader</button>
            </div>
        </form>
    </div>

    <div class="row">
        @forelse($dicoms as $dicom)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ route('dicoms.show', $dicom->id) }}" class="card-img-top" alt="DICOM Image" 
                         onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='; this.alt='Image non disponible';">
                    <div class="card-body">
                        <h5 class="card-title">{{ $dicom->filename }}</h5>
                        <p class="card-text">ID Orthanc: {{ $dicom->orthanc_id }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    Aucun fichier DICOM n'a été uploadé.
                </div>
            </div>
        @endforelse
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier le statut d'Orthanc en passant par notre proxy Laravel
    fetch('{{ route('orthanc.status') }}')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'connected') {
                document.getElementById('orthanc-status').textContent = 'Connecté (Version: ' + data.version + ')';
                document.getElementById('orthanc-status').parentElement.classList.remove('alert-info');
                document.getElementById('orthanc-status').parentElement.classList.add('alert-success');
            } else {
                document.getElementById('orthanc-status').textContent = 'Erreur: ' + data.message;
                document.getElementById('orthanc-status').parentElement.classList.remove('alert-info');
                document.getElementById('orthanc-status').parentElement.classList.add('alert-danger');
            }
        })
        .catch(error => {
            document.getElementById('orthanc-status').textContent = 'Erreur de connexion: ' + error.message;
            document.getElementById('orthanc-status').parentElement.classList.remove('alert-info');
            document.getElementById('orthanc-status').parentElement.classList.add('alert-danger');
        });
});
</script>
@endsection 