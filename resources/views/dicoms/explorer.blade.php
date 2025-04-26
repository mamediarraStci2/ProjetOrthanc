@extends('layouts.app')

@section('title', 'Explorateur DICOM')

@section('content')
<div class="container">
    <h1 class="mb-4">Explorateur d'images DICOM</h1>
    
    @if(isset($error))
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endif
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Statut Orthanc</h3>
                </div>
                <div class="card-body">
                    <p><strong>URL Orthanc:</strong> <a href="http://localhost:8042" target="_blank">http://localhost:8042</a></p>
                    <a href="http://localhost:8042" target="_blank" class="btn btn-primary">Ouvrir Orthanc Explorer</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Dossiers avec images DICOM</h3>
                </div>
                <div class="card-body">
                    @if(count($dossiers) > 0)
                        <ul class="list-group">
                            @foreach($dossiers as $dossier)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $dossier->nom }} {{ $dossier->prenom }}
                                    <div>
                                        <a href="{{ route('dossier_medical.show', $dossier->id) }}" class="btn btn-sm btn-primary">Voir dossier</a>
                                        <a href="{{ route('orthanc.redirect', $dossier->dicom_instance_id) }}" target="_blank" class="btn btn-sm btn-info">Voir dans Orthanc</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Aucun dossier médical avec image DICOM.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h3>Images DICOM dans Orthanc</h3>
        </div>
        <div class="card-body">
            @if(count($instances) > 0)
                <div class="row">
                    @foreach($instances as $instance)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="http://localhost:8042/instances/{{ $instance['id'] }}/preview" class="card-img-top" alt="Image DICOM">
                                <div class="card-body">
                                    <h5 class="card-title">ID: {{ $instance['id'] }}</h5>
                                    <p class="card-text">
                                        @if(isset($instance['details']['PatientID']))
                                            <strong>Patient ID:</strong> {{ $instance['details']['PatientID'] }}<br>
                                        @endif
                                        @if(isset($instance['details']['PatientName']))
                                            <strong>Patient:</strong> {{ $instance['details']['PatientName'] }}<br>
                                        @endif
                                        @if(isset($instance['details']['StudyDescription']))
                                            <strong>Étude:</strong> {{ $instance['details']['StudyDescription'] }}<br>
                                        @endif
                                    </p>
                                    <a href="{{ route('orthanc.redirect', $instance['id']) }}" target="_blank" class="btn btn-primary btn-sm">Ouvrir dans Orthanc</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>Aucune instance DICOM trouvée dans Orthanc.</p>
            @endif
        </div>
    </div>
</div>
@endsection 