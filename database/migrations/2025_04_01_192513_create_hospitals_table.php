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
    {Schema::create('hospitals', function (Blueprint $table) {
        $table->id();
        $table->string('nom');                   // Nom de l'hôpital
        $table->string('adresse')->nullable();   // Adresse complète
        $table->string('telephone')->nullable(); // Numéro de téléphone
        $table->string('email')->nullable();     // Email de contact
        $table->string('site_web')->nullable();  // URL du site web
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
