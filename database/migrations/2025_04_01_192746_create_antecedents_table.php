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
    { Schema::create('antecedents', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('patient_id');          // Référence au patient
        $table->string('categorie');                         // Catégorie : chirurgical, familial, médical, etc.
        $table->string('libelle');                           // Libellé court (ex : appendicectomie)
        $table->text('description')->nullable();           // Description détaillée
        $table->date('date_evenement')->nullable();        // Date de l'événement ou du diagnostic
        $table->timestamps();

        $table->foreign('patient_id')
              ->references('id')
              ->on('patients')
              ->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antecedents');
    }
};
