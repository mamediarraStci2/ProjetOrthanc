<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierMedical extends Model
{
    use HasFactory;

    // Spécifier explicitement le nom de la table
    protected $table = 'dossiers_medicaux';

    // Définition des attributs assignables en masse
    protected $fillable = [
        'patient_id',
        // Étape 1 : Informations Personnelles
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'sexe',
        'num_extrait_naissance',
        'nationalite',
        'adresse',
        'telephone',
        'email',
        'profession',
        'contact_urgence',
        'photo',

        // Étape 2 : Informations Médicales de Base
        'groupe_sanguin',
        'rhesus',
        'taille',
        'poids_actuel',
        'poids_naissance',
        'imc',
        'allergies',
        'maladies_chroniques',
        'traitements',

        // Étape 3 : Antécédents Médicaux
        'antecedents_personnels',
        'antecedents_familiaux',
        'vaccinations',
        'hospitalisations',

        // Étape 4 : Informations Familiales
        'nom_pere',
        'contact_pere',
        'nom_mere',
        'contact_mere',
        'antecedents_parents',
        'nbre_freres_soeurs',

        // Étape 5 : Informations Administratives
        'assurance_maladie',
        'num_assurance',
        'medecin_traitant',
        'etablissement_sante',

        // Étape 6 : Validation et NNS
        'nns',
        'date_creation',

        // Autres données complémentaires
        'date_derniere_prise',
        'donnees_suivis',

        // DICOM
        'dicom_instance_id',
        'dicom_metadata'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_creation' => 'datetime',
        'dicom_metadata' => 'array'
    ];
}
