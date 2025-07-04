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
        Schema::create('stagiaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('email');
            $table->string('matricule')->unique();
            $table->string('firstname');
            $table->string('name');          
            $table->date('birthdate');
            $table->string('country');
            $table->string('phone');
            $table->string('file_path')->nullable();
            $table->string('picture_path')->nullable();
            $table->string('numero_cnss')->nullable();
            $table->string('diplome_path')->nullable();
            $table->date('stage_begin')->nullable();

            $table->date('date_obtention')->nullable();
            $table->string('nom_cabinet')->nullable();
            $table->string('numero_ordre')->nullable();
            $table->string('contrat_path')->nullable();
            $table->string('numero_inscription_cabinet')->nullable();
            $table->date('first_semester_begin')->nullable();
            $table->date('first_semester_end')->nullable();
            $table->date('second_semester_begin')->nullable();
            $table->date('second_semester_end')->nullable();
            $table->date('third_semester_begin')->nullable();
            $table->date('third_semester_end')->nullable();
            $table->date('dead_first_semester')->nullable();
            $table->date('dead_second_semester')->nullable();
            $table->date('dead_third_semester')->nullable();


            //$table->date('date_entree')->nullable();
            $table->string('lieu_cabinet')->nullable();
            $table->string('tel_cabinet')->nullable();
            $table->string('email_cabinet')->nullable();
            $table->string('nom_representant')->nullable();
            $table->string('nom_maitre')->nullable();
            $table->string('prenom_maitre')->nullable();
            $table->string('numero_inscription_maitre')->nullable();

            $table->string('tel_maitre')->nullable();
            $table->boolean('validated')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stagiaires');
    }
};
