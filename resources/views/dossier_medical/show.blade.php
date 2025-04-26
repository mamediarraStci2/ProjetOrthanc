@extends('layouts.app')

@section('title', 'Dossier Médical')

@section('content')
<div class="container">
    <h2>Dossier Médical</h2>

    <div class="row">
        <!-- Informations du dossier -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Informations du Patient</h3>
    </div>
                <div class="card-body">
                    <p><strong>NNS:</strong> {{ $dossier->nns }}</p>
                    <p><strong>Nom:</strong> {{ $dossier->nom }}</p>
                    <p><strong>Prénom:</strong> {{ $dossier->prenom }}</p>
                    <p><strong>Date de naissance:</strong> {{ $dossier->date_naissance }}</p>
                    <p><strong>Lieu de naissance:</strong> {{ $dossier->lieu_naissance }}</p>
    </div>
  </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h3>Antécédents Médicaux</h3>
        </div>
        <div class="card-body">
                    <h4>Antécédents Personnels</h4>
                    <p>{{ $dossier->antecedents_personnels }}</p>

                    <h4>Antécédents Familiaux</h4>
                    <p>{{ $dossier->antecedents_familiaux }}</p>

                    <h4>Vaccinations</h4>
                    <p>{{ $dossier->vaccinations }}</p>

                    <h4>Hospitalisations</h4>
                    <p>{{ $dossier->hospitalisations }}</p>
        </div>
      </div>
    </div>

        <!-- Visualiseur DICOM -->
        <div class="col-md-6">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if($dossier->dicom_instance_id)
                <div class="card">
                    <div class="card-header">
                        <h3>Image DICOM</h3>
                        <small class="text-muted">ID Orthanc: {{ $dossier->dicom_instance_id }}</small>
        </div>
        <div class="card-body">
                        <div id="dicomViewer" style="width: 100%; position: relative;">
                            <img src="{{ route('api.dicom.image', $dossier->dicom_instance_id) }}" alt="Image DICOM" 
                                 class="img-fluid" id="dicomImage" style="max-width: 100%;" />
                            
                            <div class="controls mt-3 text-center">
                                <button class="btn btn-sm btn-primary" id="zoomIn">Zoom +</button>
                                <button class="btn btn-sm btn-primary" id="zoomOut">Zoom -</button>
                                <button class="btn btn-sm btn-secondary" id="resetZoom">Reset</button>
                                <a href="{{ route('orthanc.redirect', $dossier->dicom_instance_id) }}" class="btn btn-sm btn-info" target="_blank">Visualiser dans Orthanc</a>
                            </div>
        </div>
      </div>
    </div>
            @else
                <div class="card">
                    <div class="card-header">
                        <h3>Image DICOM</h3>
        </div>
        <div class="card-body">
                        <div class="alert alert-info">
                            Aucune image DICOM n'est associée à ce dossier médical.
                        </div>
                    </div>
                </div>
            @endif
      </div>
    </div>
  </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const image = document.getElementById('dicomImage');
        if (!image) return;
        
        let scale = 1;
        const zoomInBtn = document.getElementById('zoomIn');
        const zoomOutBtn = document.getElementById('zoomOut');
        const resetBtn = document.getElementById('resetZoom');
        
        zoomInBtn.addEventListener('click', function() {
            scale += 0.1;
            updateScale();
        });
        
        zoomOutBtn.addEventListener('click', function() {
            if (scale > 0.2) {
                scale -= 0.1;
                updateScale();
            }
        });
        
        resetBtn.addEventListener('click', function() {
            scale = 1;
            updateScale();
        });
        
        function updateScale() {
            image.style.transform = `scale(${scale})`;
            image.style.transformOrigin = 'center center';
        }
    });
</script>
@endpush

@endsection
