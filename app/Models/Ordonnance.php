<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordonnance extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'prescriptions',
        'date_prescription',
        'date_expiration',
    ];

    protected $casts = [
        'date_prescription' => 'date',
        'date_expiration' => 'date',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}