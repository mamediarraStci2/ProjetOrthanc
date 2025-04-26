<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\Patient;
use App\Models\DossierMedical;
use App\Models\RendezVous;
use App\Models\Ordonnance;
use App\Models\SpecialiteMedicale;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MedecinController extends Controller
{
    public function index()
    {
        $medecins = Medecin::with(['utilisateur', 'specialite'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $specialites = SpecialiteMedicale::all();
        return view('medecins.index', compact('medecins', 'specialites'));
    }

    public function create()
    {
        $specialites = SpecialiteMedicale::all();
        return view('medecins.create', compact('specialites'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'utilisateur_id' => 'required|exists:utilisateurs,id',
            'specialite_medicale_id' => 'required|exists:specialite_medicales,id',
            'hopital' => 'required|string|max:255',
        ]);

        Medecin::create($validated);
        return redirect()->route('medecins.index')->with('success', 'Médecin ajouté avec succès');
    }

    public function show(Medecin $medecin)
    {
        return view('medecins.show', compact('medecin'));
    }

    public function edit(Medecin $medecin)
    {
        $specialites = SpecialiteMedicale::all();
        return view('medecins.edit', compact('medecin', 'specialites'));
    }

    public function update(Request $request, Medecin $medecin)
    {
        $validated = $request->validate([
            'specialite_medicale_id' => 'required|exists:specialite_medicales,id',
            'hopital' => 'required|string|max:255',
        ]);

        $medecin->update($validated);
        return redirect()->route('medecins.index')->with('success', 'Informations du médecin mises à jour');
    }

    public function destroy(Medecin $medecin)
    {
        $medecin->delete();
        return redirect()->route('medecins.index')->with('success', 'Médecin supprimé avec succès');
    }

    public function dashboard()
    {
        // Pour le moment, on affiche tous les patients sans filtrer par médecin
        $patients = Patient::all();
        
        // Pour les rendez-vous, on les affiche tous pour l'instant
        $rendezVous = RendezVous::whereDate('date_heure', Carbon::today())
            ->orderBy('date_heure')
            ->get();

        $statsJour = [
            'patients' => $rendezVous->count(),
            'attente' => RendezVous::where('is_validated', false)->count()
        ];

        return view('medecins.dashboard', compact('patients', 'rendezVous', 'statsJour'));
    }

    public function editDossier(Patient $patient)
    {
        $dossier = DossierMedical::firstOrCreate(['patient_id' => $patient->id]);
        return view('medecins.dossier.edit', compact('patient', 'dossier'));
    }

    public function updateDossier(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'antecedents' => 'nullable|string',
            'allergies' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $dossier = DossierMedical::updateOrCreate(
            ['patient_id' => $patient->id],
            $validated
        );

        return redirect()->back()->with('success', 'Dossier médical mis à jour avec succès');
    }

    public function createRendezVous(Patient $patient)
    {
        return view('medecins.rendez_vous.create', compact('patient'));
    }

    public function storeRendezVous(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'heure' => 'required',
            'motif' => 'required|string',
        ]);

        $rendezVous = new RendezVous();
        $rendezVous->date_heure = Carbon::parse($validated['date'] . ' ' . $validated['heure']);
        $rendezVous->sujet = $validated['motif'];
        $rendezVous->patient_id = $patient->id;
        $rendezVous->medecin_id = 1; // Temporaire : on met un ID par défaut
        $rendezVous->is_validated = true;
        $rendezVous->save();

        return redirect()->route('medecin.dashboard')->with('success', 'Rendez-vous programmé avec succès');
    }

    public function createOrdonnance(Patient $patient)
    {
        return view('medecins.ordonnance.create', compact('patient'));
    }

    public function storeOrdonnance(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'medicaments' => 'required|array',
            'posologies' => 'required|array',
            'durees' => 'required|array',
            'instructions' => 'nullable|string',
        ]);

        $ordonnance = new Ordonnance([
            'date' => $validated['date'],
            'instructions' => $validated['instructions'],
            'contenu' => array_map(function($medicament, $posologie, $duree) {
                return [
                    'medicament' => $medicament,
                    'posologie' => $posologie,
                    'duree' => $duree
                ];
            }, $validated['medicaments'], $validated['posologies'], $validated['durees'])
        ]);

        $ordonnance->patient_id = $patient->id;
        // Pour l'instant, on ne lie pas l'ordonnance à un médecin spécifique
        $ordonnance->save();

        return redirect()->route('medecin.dashboard')->with('success', 'Ordonnance créée avec succès');
    }
}