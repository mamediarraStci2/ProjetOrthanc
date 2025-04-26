<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            SpecialiteMedicaleSeeder::class,
        ]);

        // Créer les utilisateurs
        $users = [
            [
                'name' => 'Admin System',
                'email' => 'admin@hopital.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Docteur Diallo',
                'email' => 'medecin@hopital.com',
                'password' => Hash::make('medecin123'),
                'role' => 'medecin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Secrétaire Sow',
                'email' => 'secretaire@hopital.com',
                'password' => Hash::make('secretaire123'),
                'role' => 'secretaire',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Patient Fall',
                'email' => 'patient@hopital.com',
                'password' => Hash::make('patient123'),
                'role' => 'patient',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
