<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DossierMedical;
use App\Models\RendezVous;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        // Statistiques
        $stats = [
            'patients' => User::where('role', 'patient')->count(),
            'medecins' => User::where('role', 'medecin')->count(),
            'secretaires' => User::where('role', 'secretaire')->count(),
            'rendezVous' => RendezVous::whereDate('date_heure', Carbon::today())->count(),
        ];

        // Rendez-vous récents
        $recentAppointments = RendezVous::with(['patient', 'medecin'])
            ->orderBy('date_heure', 'desc')
            ->take(5)
            ->get();

        // Dernières connexions
        $recentLogins = AuditLog::with('user')
            ->where('event', 'login')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        if(request()->ajax()) {
            return view('admin.dashboard', compact('stats', 'recentAppointments', 'recentLogins'))->render();
        }
        return view('admin.dashboard', compact('stats', 'recentAppointments', 'recentLogins'));
    }

    public function medecins()
    {
        $medecins = User::where('role', 'medecin')->get();
        if(request()->ajax()) {
            return view('admin.medecins.index', compact('medecins'))->render();
        }
        return view('admin.medecins.index', compact('medecins'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $criteria = $request->input('criteria', []);

        if (empty($criteria)) {
            return back()->with('error', 'Veuillez sélectionner au moins un critère de recherche.');
        }

        $results = collect();

        if (in_array('nns', $criteria)) {
            $results = $results->merge(
                DossierMedical::where('nns', 'LIKE', "%{$query}%")->get()
            );
        }

        if (in_array('nin', $criteria)) {
            $results = $results->merge(
                DossierMedical::where('nin', 'LIKE', "%{$query}%")->get()
            );
        }

        if (in_array('extrait', $criteria)) {
            $results = $results->merge(
                DossierMedical::where('num_extrait_naissance', 'LIKE', "%{$query}%")->get()
            );
        }

        if (in_array('nomprenom', $criteria)) {
            $results = $results->merge(
                DossierMedical::where('nom', 'LIKE', "%{$query}%")
                    ->orWhere('prenom', 'LIKE', "%{$query}%")
                    ->get()
            );
        }

        // Supprimer les doublons
        $results = $results->unique('id');

        if ($request->ajax()) {
            return view('admin.partials.search_results', compact('results'))->render();
        }

        return view('admin.dashboard', compact('results'));
    }

    public function logs()
    {
        $logs = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        if(request()->ajax()) {
            return view('admin.logs.index', compact('logs'))->render();
        }
        return view('admin.logs.index', compact('logs'));
    }
} 