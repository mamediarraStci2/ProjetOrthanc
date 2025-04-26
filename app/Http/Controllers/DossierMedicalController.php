<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DossierMedical;
use App\Models\Patient;
use App\Services\OrthancService;

class DossierMedicalController extends Controller
{
    protected $orthancService;

    public function __construct(OrthancService $orthancService)
    {
        $this->orthancService = $orthancService;
    }

    public function create()
    {
        return view('dossier_medical.create_wizard');
    }

    public function store(Request $request)
    {
        // Validation de toutes les données issues du formulaire multi‑étapes.
        $validated = $request->validate([
            // Informations Personnelles (Étape 1)
            'nom'                   => 'required|string|max:255',
            'prenom'                => 'required|string|max:255',
            'date_naissance'        => 'required|date',
            'lieu_naissance'        => 'required|string|max:255',
            'sexe'                  => 'required|in:Masculin,Féminin,Autre',
            'num_extrait_naissance' => 'required|string|max:50',
            'nationalite'           => 'nullable|string|max:100',
            'adresse'               => 'nullable|string|max:500',
            'telephone'             => 'nullable|string|max:50',
            'email'                 => 'nullable|email|max:255',
            'profession'            => 'nullable|string|max:255',
            'contact_urgence'       => 'nullable|string|max:255',
            'photo'                 => 'nullable|image',

            // Informations Médicales de Base (Étape 2)
            'groupe_sanguin'        => 'nullable|string|max:10',
            'rhesus'                => 'nullable|string|max:10',
            'taille'                => 'nullable|numeric',
            'poids_actuel'          => 'nullable|numeric',
            'poids_naissance'       => 'nullable|numeric',
            'imc'                   => 'nullable|numeric',
            'allergies'             => 'nullable|string',
            'maladies_chroniques'   => 'nullable|string',
            'traitements'           => 'nullable|string',

            // Antécédents Médicaux (Étape 3)
            'antecedents_personnels'=> 'nullable|string',
            'antecedents_familiaux' => 'nullable|string',
            'vaccinations'          => 'nullable',
            'hospitalisations'      => 'nullable|string',

            // Informations Familiales (Étape 4)
            'nom_pere'              => 'nullable|string|max:255',
            'contact_pere'          => 'nullable|string|max:50',
            'nom_mere'              => 'nullable|string|max:255',
            'contact_mere'          => 'nullable|string|max:50',
            'antecedents_parents'   => 'nullable|string',
            'nbre_freres_soeurs'    => 'nullable|integer',

            // Informations Administratives (Étape 5)
            'assurance_maladie'     => 'nullable|string|max:255',
            'num_assurance'         => 'nullable|string|max:100',
            'medecin_traitant'      => 'nullable|string|max:255',
            'etablissement_sante'   => 'nullable|string|max:255',

            // NNS (Étape 6) – si non fourni, sera généré automatiquement
            'nns'                   => 'nullable|string|max:50',

            'dicom_image' => 'nullable|file|mimes:dcm',
        ]);

        // Calcul côté serveur de l'IMC si taille et poids sont renseignés
        if (!empty($validated['taille']) && !empty($validated['poids_actuel'])) {
            $validated['imc'] = round($validated['poids_actuel'] / (($validated['taille'] / 100) ** 2), 2);
        }

        // Génération automatique du NNS si non renseigné.
        if (empty($validated['nns'])) {
            $nomPart = strtoupper(substr($validated['nom'], 0, 3));
            $annee = date('Y', strtotime($validated['date_naissance']));
            $lieuPart = strtoupper(substr($validated['lieu_naissance'], 0, 3));
            $extraitPart = substr(preg_replace('/\D/', '', $validated['num_extrait_naissance']), -4);
            $validated['nns'] = "DOS-{$nomPart}-{$annee}-{$lieuPart}-{$extraitPart}";
        }

        // Ajout de la date de création du dossier
        $validated['date_creation'] = now();

        // Créer le dossier médical.
        // (Notez que, dans votre table, vous avez un champ patient_id non nullable.
        // Ici, nous allons d'abord créer le dossier sans patient_id, puis le mettre à jour une fois le patient créé.)
        // Vous pouvez temporairement ignorer patient_id via la validation de masse en vous assurant qu'il existe dans $fillable.
        $dossier = DossierMedical::create($validated);

        // Upload DICOM image if provided
        if ($request->hasFile('dicom_image')) {
            try {
                $result = $this->orthancService->uploadDicom($request->file('dicom_image'));
                if ($result) {
                    $dossier->dicom_instance_id = $result['ID'] ?? null;
                    $dossier->dicom_metadata = $result;
                    $dossier->save();
                }
            } catch (\Exception $e) {
                // Log error but continue with dossier creation
                \Log::error('Failed to upload DICOM: ' . $e->getMessage());
            }
        }

        // Maintenant, créer (ou mettre à jour) le Patient à partir des informations du dossier.
        // On utilise le NNS (généré ou fourni) comme identifiant unique métier.
        $patient = Patient::updateOrCreate(
            ['nss' => $dossier->nns],
            [
                'nom'            => $dossier->nom,
                'prenom'         => $dossier->prenom,
                'date_naissance' => $dossier->date_naissance,
                'lieu_naissance' => $dossier->lieu_naissance,
                // Vous pouvez également stocker les autres informations personnelles dans "informations" si nécessaire.
            ]
        );

        // Optionnel : mettre à jour le dossier médical pour y enregistrer la relation patient_id
        $dossier->patient_id = $patient->id;
        $dossier->save();

        return redirect()->route('dossier_medical.show', $dossier->id)
                         ->with('success', 'Dossier médical créé avec succès !');
    }

    public function show($id)
    {
        $dossier = DossierMedical::findOrFail($id);
        $dicomImage = null;
        
        if ($dossier->dicom_instance_id) {
            try {
                $dicomImage = $this->orthancService->getInstance($dossier->dicom_instance_id);
            } catch (\Exception $e) {
                \Log::error('Failed to fetch DICOM image: ' . $e->getMessage());
            }
        }
        
        return view('dossier_medical.show', compact('dossier', 'dicomImage'));
    }
}
