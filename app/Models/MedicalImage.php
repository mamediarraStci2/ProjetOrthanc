<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalImage extends Model
{
    protected $fillable = [
        'patient_id',
        'consultation_id',
        'orthanc_study_id',
        'image_type',
        'description'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}