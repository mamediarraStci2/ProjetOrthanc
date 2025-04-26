<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrateur avec tous les droits',
            ],
            [
                'name' => 'medecin',
                'description' => 'Médecin avec accès aux dossiers patients',
            ],
            [
                'name' => 'secretaire',
                'description' => 'Secrétaire médical avec accès limité',
            ],
            [
                'name' => 'patient',
                'description' => 'Patient avec accès à son propre dossier',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
} 