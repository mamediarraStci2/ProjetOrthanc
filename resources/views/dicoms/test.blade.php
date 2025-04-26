<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test DICOM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        .status {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .status.ok {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .status.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .image-container {
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 20px;
            text-align: center;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        .form {
            margin: 20px 0;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 4px;
        }
        input[type="file"] {
            display: block;
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #0069d9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test d'affichage DICOM</h1>
        
        <div id="orthancStatus" class="status">Vérification de la connexion à Orthanc...</div>
        
        <div class="form">
            <form action="{{ route('dicoms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".dcm">
                <button type="submit">Uploader DICOM</button>
            </form>
        </div>

        @if(isset($error))
            <div class="status error">
                <strong>Erreur:</strong> {{ $error }}
            </div>
        @endif

        @if(session('success'))
            <div class="status ok">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="status error">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="image-container">
            <h2>Images DICOM disponibles</h2>
            
            @forelse($dicoms as $dicom)
                <div style="margin-bottom: 30px;">
                    <h3>{{ $dicom->filename }}</h3>
                    <p>ID Orthanc: {{ $dicom->orthanc_id }}</p>
                    <img src="{{ route('dicoms.show', $dicom->id) }}" alt="DICOM Image" 
 