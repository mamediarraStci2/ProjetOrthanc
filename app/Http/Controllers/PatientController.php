<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Affiche la liste de tous les patients.
     */
    public function index()
    {
        $patients = Patient::orderBy('nom')->paginate(10);
        return view('patients.index', compact('patients'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau patient.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Stocke le nouveau patient en base.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nss'             => 'required|string|unique:patients,nss',
            'nom'             => 'required|string|max:255',
            'prenom'          => 'required|string|max:255',
            'date_naissance'  => 'required|date',
            'lieu_naissance'  => 'required|string|max:255',
            'informations'    => 'nullable|string',
        ]);

        $patient = Patient::create($validated);

        return redirect()->route('patients.show', $patient->id)
                         ->with('success', 'Patient créé avec succès.');
    }

    /**
     * Affiche un patient.
     */
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    /**
     * Affiche le formulaire d'édition d'un patient.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Met à jour un patient.
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'nss'             => 'required|string|unique:patients,nss,' . $patient->id,
            'nom'             => 'required|string|max:255',
            'prenom'          => 'required|string|max:255',
            'date_naissance'  => 'required|date',
            'lieu_naissance'  => 'required|string|max:255',
            'informations'    => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.show', $patient->id)
                         ->with('success', 'Patient mis à jour avec succès.');
    }

    /**
     * Supprime un patient.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')
                         ->with('success', 'Patient supprimé avec succès.');
    }
}
