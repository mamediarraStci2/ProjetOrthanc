<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    use HasFactory;

    protected $table = 'medecins';

    protected $fillable = [
        'utilisateur_id',
        'specialite_medicale_id',
        'hopital',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function specialite()
    {
        return $this->belongsTo(SpecialiteMedicale::class, 'specialite_medicale_id');
    }

    public function patients()
    {
        return $this->hasMany(DossierMedical::class);
    }
}