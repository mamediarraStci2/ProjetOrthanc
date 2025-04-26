<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\DossierMedical;
use App\Models\Medecin;
use Illuminate\Http\Request;

class PatientDashboardController extends Controller
{
    public function index()
    {
        // Pour le moment, on affiche juste la vue sans données
        return view('patients.dashboard');
    }

    public function demanderRendezVous()
    {
        $medecins = Medecin::all();
        return view('patients.rendez_vous.create', compact('medecins'));
    }

    public function storeRendezVous(Request $request)
    {
        $validated = $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date_heure' => 'required|date|after:now',
            'motif' => 'required|string|max:255',
        ]);

        // Pour le moment, on redirige simplement
        return redirect()->route('patient.dashboard')
            ->with('success', 'Votre demande de rendez-vous a été enregistrée.');
    }

    public function voirOrdonnances()
    {
        // Pour le moment, on retourne une vue vide
        return view('patients.ordonnances.index');
    }
}