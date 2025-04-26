<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalImagesTable extends Migration
{
    public function up()
    {
        Schema::create('medical_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('consultation_id')->constrained('consultations');
            $table->string('orthanc_study_id');
            $table->string('image_type');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medical_images');
    }
}