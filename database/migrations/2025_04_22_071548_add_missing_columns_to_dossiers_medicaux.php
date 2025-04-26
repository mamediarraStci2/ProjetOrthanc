<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dossiers_medicaux', function (Blueprint $table) {
            // Vérification et ajout des colonnes manquantes
            if (!Schema::hasColumn('dossiers_medicaux', 'poids_naissance')) {
                $table->float('poids_naissance')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'imc')) {
                $table->float('imc')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'allergies')) {
                $table->text('allergies')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'maladies_chroniques')) {
                $table->text('maladies_chroniques')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'traitements')) {
                $table->text('traitements')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'antecedents_personnels')) {
                $table->text('antecedents_personnels')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'antecedents_familiaux')) {
                $table->text('antecedents_familiaux')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'vaccinations')) {
                $table->text('vaccinations')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'hospitalisations')) {
                $table->text('hospitalisations')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'nom_pere')) {
                $table->string('nom_pere')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'contact_pere')) {
                $table->string('contact_pere')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'nom_mere')) {
                $table->string('nom_mere')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'contact_mere')) {
                $table->string('contact_mere')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'antecedents_parents')) {
                $table->text('antecedents_parents')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'nbre_freres_soeurs')) {
                $table->integer('nbre_freres_soeurs')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'assurance_maladie')) {
                $table->string('assurance_maladie')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'num_assurance')) {
                $table->string('num_assurance')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'medecin_traitant')) {
                $table->string('medecin_traitant')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'etablissement_sante')) {
                $table->string('etablissement_sante')->nullable();
            }
            
            if (!Schema::hasColumn('dossiers_medicaux', 'date_creation')) {
                $table->timestamp('date_creation')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dossiers_medicaux', function (Blueprint $table) {
            // Suppression des colonnes ajoutées
            $table->dropColumn([
                'poids_naissance',
                'imc',
                'allergies',
                'maladies_chroniques',
                'traitements',
                'antecedents_personnels',
                'antecedents_familiaux',
                'vaccinations',
                'hospitalisations',
                'nom_pere',
                'contact_pere',
                'nom_mere',
                'contact_mere',
                'antecedents_parents',
                'nbre_freres_soeurs',
                'assurance_maladie',
                'num_assurance',
                'medecin_traitant', 
                'etablissement_sante',
                'date_creation'
            ]);
        });
    }
};
