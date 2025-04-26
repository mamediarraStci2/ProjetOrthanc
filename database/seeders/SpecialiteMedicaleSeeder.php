<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SpecialiteMedicale;

class SpecialiteMedicaleSeeder extends Seeder
{
    public function run(): void
    {
        $specialites = [
            'Cardiologie',
            'Dermatologie',
            'Pédiatrie',
            'Neurologie',
            'Ophtalmologie',
            'Gynécologie',
            'Psychiatrie',
            'Radiologie',
            'Chirurgie générale',
            'Médecine interne'
        ];

        foreach ($specialites as $specialite) {
            SpecialiteMedicale::create([
                'libelle' => $specialite
            ]);
        }
    }
}