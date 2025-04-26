<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialiteMedicale extends Model
{
    use HasFactory;

    protected $table = 'specialite_medicales';

    protected $fillable = [
        'libelle',
    ];

    public function medecins()
    {
        return $this->hasMany(Medecin::class);
    }
}