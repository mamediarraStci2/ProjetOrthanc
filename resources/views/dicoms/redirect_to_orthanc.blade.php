<!DOCTYPE html>
<html>
<head>
    <title>Redirection vers Orthanc</title>
    @if(isset($studyId))
    <meta http-equiv="refresh" content="0; URL=http://localhost:8042/app/explorer.html#study?uuid={{ $studyId }}">
    <script>
        window.location.href = "http://localhost:8042/app/explorer.html#study?uuid={{ $studyId }}";
    </script>
    @else
    <meta http-equiv="refresh" content="0; URL=http://localhost:8042/app/explorer.html">
    <script>
        window.location.href = "http://localhost:8042/app/explorer.html";
    </script>
    @endif
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            color: #333;
        }
        .options {
            margin-top: 30px;
        }
        .option {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        a {
            display: inline-block;
            padding: 8px 15px;
            background-color: #0066cc;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        a:hover {
            background-color: #0052a3;
        }
        .info {
            margin-top: 20px;
            padding: 10px;
            background-color: #f0f7ff;
            border-left: 4px solid #0066cc;
            border-radius: 3px;
        }
        .error {
            background-color: #fff0f0;
            border-left: 4px solid #cc0000;
            padding: 10px;
            margin-bottom: 20px;
        }
        code {
            font-family: monospace;
            background: #f0f0f0;
            padding: 2px 4px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Visionneuse DICOM</h1>
        
        @if(isset($error))
        <div class="error">
            <h3>Erreur</h3>
            <p>{{ $error }}</p>
        </div>
        @endif
        
        <div class="redirect-message">
            <p>Redirection vers Orthanc en cours...</p>
            <p>Si vous n'êtes pas redirigé automatiquement, utilisez l'une des options ci-dessous.</p>
        </div>
        
        <div class="options">
            <div class="option">
                <h3>Explorer les données DICOM</h3>
                
                @if(isset($studyId))
                <p>
                    <a href="{{ $orthancUrl }}/app/explorer.html#study?uuid={{ $studyId }}" target="_blank">Ouvrir l'étude</a>
                    <a href="{{ $orthancUrl }}/studies/{{ $studyId }}" target="_blank">API de l'étude</a>
                </p>
                @endif
                
                @if(isset($seriesId))
                <p>
                    <a href="{{ $orthancUrl }}/app/explorer.html#series?uuid={{ $seriesId }}" target="_blank">Ouvrir la série</a>
                    <a href="{{ $orthancUrl }}/series/{{ $seriesId }}" target="_blank">API de la série</a>
                </p>
                @endif
                
                <p>
                    <a href="{{ $orthancUrl }}/app/explorer.html#instance?uuid={{ $instanceId }}" target="_blank">Ouvrir l'instance</a>
                    <a href="{{ $orthancUrl }}/instances/{{ $instanceId }}" target="_blank">API de l'instance</a>
                </p>
                
                <p>
                    <a href="{{ $orthancUrl }}/app/explorer.html" target="_blank">Explorateur Orthanc complet</a>
                </p>
            </div>
            
            <div class="option">
                <h3>Visualisation directe</h3>
                <p>
                    <a href="{{ $orthancUrl }}/instances/{{ $instanceId }}/preview" target="_blank">Aperçu simple</a>
                    <a href="{{ $orthancUrl }}/instances/{{ $instanceId }}/file" target="_blank">Télécharger DICOM</a>
                    <a href="{{ $orthancUrl }}/osimis-viewer/app/index.html?study={{ $studyId ?? '' }}" target="_blank">Visionneuse avancée</a>
                </p>
            </div>
            
            <div class="option">
                <h3>Alternative: Visionneuse Stone</h3>
                <p>
                    <a href="{{ $orthancUrl }}/stone-webviewer/index.html?study={{ $studyId ?? '' }}" target="_blank">Stone Webviewer</a>
                </p>
            </div>
            
            @if(isset($instanceData))
            <div class="info">
                <h3>Informations sur l'image</h3>
                <p><strong>ID d'instance:</strong> <code>{{ $instanceId }}</code></p>
                @if(isset($seriesId))
                <p><strong>ID de série:</strong> <code>{{ $seriesId }}</code></p>
                @endif
                @if(isset($studyId))
                <p><strong>ID d'étude:</strong> <code>{{ $studyId }}</code></p>
                @endif
                @if(isset($patientId))
                <p><strong>ID patient:</strong> <code>{{ $patientId }}</code></p>
                @endif
                
                @if(isset($instanceData['MainDicomTags']['SOPInstanceUID']))
                <p><strong>UID de l'instance DICOM:</strong> <code>{{ $instanceData['MainDicomTags']['SOPInstanceUID'] }}</code></p>
                @endif
                
                @if(isset($instanceData['MainDicomTags']['PatientName']))
                <p><strong>Nom du patient:</strong> {{ $instanceData['MainDicomTags']['PatientName'] }}</p>
                @endif
                
                @if(isset($instanceData['MainDicomTags']['StudyDescription']))
                <p><strong>Description de l'étude:</strong> {{ $instanceData['MainDicomTags']['StudyDescription'] }}</p>
                @endif
            </div>
            @endif
        </div>
    </div>
</body>
</html> 