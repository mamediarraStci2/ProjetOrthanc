<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    // Indiquer le nom de la table si besoin (optionnel, ici la convention fonctionne : "patients")
    protected $table = 'patients';

    // Définir les champs assignables en masse
    protected $fillable = [
        'utilisateur_id',
        'nss',
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'informations',
    ];

    /**
     * Exemple de relation : un patient peut avoir plusieurs dossiers médicaux.
     */
    public function dossiersMedicaux()
    {
        return $this->hasMany(DossierMedical::class);
    }
}
