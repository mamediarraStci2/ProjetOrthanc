<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Affiche la page dashboard.
     */
    public function index()
    {
        // Récupère ici les données que tu veux passer à la vue
        // par exemple : $stats = ...;

        return view('dashboard.index', [
            // 'stats' => $stats,
        ]);
    }
}
