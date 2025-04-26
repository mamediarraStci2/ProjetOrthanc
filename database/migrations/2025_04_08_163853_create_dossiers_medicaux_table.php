<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dossiers_medicaux', function (Blueprint $table) {
            $table->id();

            // Lien vers la table patients
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patients')
                  ->onDelete('cascade');

            /*
             * Étape 1 : Informations Personnelles
             */
            $table->string('nom');                       // Nom du patient
            $table->string('prenom');                    // Prénom
            $table->date('date_naissance');              // Date de naissance
            $table->string('lieu_naissance');            // Lieu de naissance
            $table->string('sexe');                      // Sexe (Masculin, Féminin, Autre)
            $table->string('num_extrait_naissance');     // Numéro d'extrait de naissance ou CNI
            $table->string('nationalite')->nullable();   // Nationalité
            $table->text('adresse')->nullable();         // Adresse complète
            $table->string('telephone')->nullable();     // Téléphone
            $table->string('email')->nullable();         // Email
            $table->string('profession')->nullable();    // Profession
            $table->string('contact_urgence')->nullable(); // Personne à contacter en cas d'urgence (nom, téléphone, relation)
            $table->string('photo')->nullable();         // Chemin vers la photo (optionnel)

            /*
             * Étape 2 : Informations Médicales de Base
             */
            $table->string('groupe_sanguin')->nullable();
            $table->string('rhesus')->nullable();
            $table->float('taille')->nullable();          // en cm
            $table->float('poids')->nullable();           // Poids actuel en kg
            $table->float('poids_naissance')->nullable(); // Pour nouveau-né
            $table->float('imc')->nullable();             // IMC calculé
            $table->text('allergies')->nullable();
            $table->text('maladies_chroniques')->nullable();
            $table->text('traitements_en_cours')->nullable();

            /*
             * Étape 3 : Antécédents Médicaux
             */
            $table->text('antecedents_personnels')->nullable();
            $table->text('antecedents_familiaux')->nullable();
            $table->json('vaccinations')->nullable();   // Format JSON pour stocker vaccinations (dates et désignations)
            $table->text('hospitalisations')->nullable();

            /*
             * Étape 4 : Informations Familiales
             */
            $table->string('nom_pere')->nullable();
            $table->string('contact_pere')->nullable();
            $table->string('nom_mere')->nullable();
            $table->string('contact_mere')->nullable();
            $table->text('antecedents_parents')->nullable();
            $table->text('fratrie_etat_sante')->nullable();  // Nombre et état de santé des frères/sœurs ou description

            /*
             * Étape 5 : Informations Administratives
             */
            $table->string('assurance_nom')->nullable();    // Nom de l'assurance maladie
            $table->string('assurance_numero')->nullable(); // Numéro d'assurance
            $table->string('medecin_traitant')->nullable();
            $table->string('etablissement_sante')->nullable();

            /*
             * Étape 6 : Validation et Génération du NNS
             */
            $table->string('nns')->unique()->nullable();  // Numéro National de Santé
            // Date de création du dossier (sera définie lors de l'enregistrement)
            $table->dateTime('date_creation')->default(now());

            // Données supplémentaires / suivis (ex. historique, prescriptions, etc.)
            $table->dateTime('date_derniere_prise')->nullable();
            $table->longText('donnees_suivis')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dossiers_medicaux');
    }
};
