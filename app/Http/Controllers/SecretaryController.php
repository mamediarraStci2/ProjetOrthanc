<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DossierMedical;
use App\Models\RendezVous;

class SecretaryController extends Controller
{
    /**
     * Affiche le dashboard de la secrétaire avec les dossiers récents et les rendez‑vous.
     */
    public function dashboard()
    {
        return view('secretary.dashboard');
    }

    /**
     * Recherche les dossiers médicaux selon les critères spécifiés.
     * Si la requête est AJAX, renvoie uniquement le contenu HTML pour l'aperçu live.
     */
    public function search(Request $request)
    {
        $criteria = $request->input('criteria', []);
        $query = $request->input('query', '');
        $dossiersQuery = DossierMedical::query();

        if (!empty($criteria)) {
            foreach ($criteria as $crit) {
                if ($crit == 'nns') {
                    $dossiersQuery->orWhere('nns', 'LIKE', "%{$query}%");
                }
                if ($crit == 'nin') {
                    // Assure-toi que la colonne "nin" existe sinon adapte ou retire ce critère
                    $dossiersQuery->orWhere('nin', 'LIKE', "%{$query}%");
                }
                if ($crit == 'extrait') {
                    $dossiersQuery->orWhere('num_extrait_naissance', 'LIKE', "%{$query}%");
                }
                if ($crit == 'nomprenom') {
                    $dossiersQuery->orWhere('nom', 'LIKE', "%{$query}%")
                                  ->orWhere('prenom', 'LIKE', "%{$query}%");
                }
            }
        }

        $results = $dossiersQuery->get();

        if ($request->ajax()) {
            return view('secretary.search_results', compact('results'));
        }

        return view('secretary.search_results', compact('results'));
    }
}
