<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sénégal Care - @yield('title')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <style>
    :root {
      --bleu-medical: #1A7BB7;
      --vert-menthe: #4ECDC4;
      --blanc-pur: #FFFFFF;
      --gris-clair: #F5F5F7;
      --bleu-fonce: #0D4C73;
      --vert-emeraude: #2D9D8A;
      --saumon-clair: #FFA69E;
      --accent-hospital: #E74C3C;
    }

    body {
      background-color: var(--gris-clair);
      color: var(--bleu-fonce);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      position: relative;
    }

    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url('https://www.transparenttextures.com/patterns/diagmonds-light.png');
      opacity: 0.1;
      z-index: -2;
    }

    .header-block {
      background: linear-gradient(45deg, var(--bleu-medical), var(--vert-menthe));
      padding: 1rem 2rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      border-bottom: 3px solid var(--accent-hospital);
      position: relative;
      overflow: hidden;
    }

    .header-block::after {
      content: "";
      position: absolute;
      bottom: -20px;
      right: -20px;
      width: 100px;
      height: 100px;
      background: var(--blanc-pur);
      border-radius: 50%;
      opacity: 0.15;
      animation: pulse 3s infinite;
    }

    @keyframes pulse {
      0% { transform: scale(0.8); opacity: 0.2; }
      50% { transform: scale(1.2); opacity: 0.05; }
      100% { transform: scale(0.8); opacity: 0.2; }
    }

    .navbar {
      background: transparent;
      padding: 0;
    }

    .nav-link {
      color: var(--blanc-pur) !important;
      font-weight: 600;
      transition: color 0.3s;
    }

    .nav-link:hover {
      color: var(--saumon-clair) !important;
    }

    .app-logo {
      height: 150px; /* Augmentation de la taille du logo */
      width: auto;
    }

    .search-block {
      background-color: rgba(255, 255, 255, 0.2);
      padding: 1rem;
      border-radius: 8px;
    }

    .input-group-lg > .form-control {
      font-size: 1rem;
      padding: 0.75rem 1rem;
    }

    .btn-lg {
      font-size: 1rem;
      padding: 0.6rem 1rem;
    }

    .loading-spinner {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 9999;
    }

    .spinner-border-custom {
      width: 3rem;
      height: 3rem;
      border-width: 0.4em;
      color: var(--vert-emeraude);
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    footer {
      background-color: var(--bleu-fonce);
      color: var(--blanc-pur);
      padding: 20px 0;
      text-align: center;
      margin-top: 2rem;
    }

    .bg-primary {
      background-color: #0072bc;
    }
    .bg-secondary {
      background-color: #00a99d;
    }
    .text-primary {
      color: #0072bc;
    }
    .text-secondary {
      color: #00a99d;
    }
    .btn-primary {
      background-color: #0072bc;
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 0.5rem;
      font-weight: 600;
      transition: background-color 0.2s;
    }
    .btn-primary:hover {
      background-color: #005a94;
    }

    .form-input {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid #e2e8f0;
      border-radius: 0.375rem;
      margin-top: 0.25rem;
    }

    .form-input:focus {
      outline: none;
      border-color: #0072bc;
      box-shadow: 0 0 0 3px rgba(0, 114, 188, 0.1);
    }

    .form-checkbox {
      width: 1rem;
      height: 1rem;
      border-radius: 0.25rem;
      border: 1px solid #e2e8f0;
    }

    .form-checkbox:checked {
      background-color: #0072bc;
      border-color: #0072bc;
    }
  </style>
  @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen">
  <div class="loading-spinner d-none" id="loadingSpinner">
    <div class="spinner-border spinner-border-custom" role="status">
      <span class="visually-hidden">Chargement...</span>
    </div>
  </div>

  <main class="container py-4">
    @yield('content')
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const spinner = document.getElementById('loadingSpinner');
      spinner.classList.remove('d-none');
      setTimeout(() => { spinner.classList.add('d-none'); }, 2000);
    });
  </script>
  @stack('scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  </script>
</body>
</html>
