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
            $table->foreignId('affiliation_order_id')->nullable();

            $table->string('email');
            $table->string('matricule')->unique();
            $table->boolean('validated')->default(false);

            $table->integer('year')->default(1);
            $table->string('firstname');
            $table->string('name');          
            $table->date('birthdate');
            $table->string('country');
            $table->string('affiliation_order')->nullable();

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
            $table->date('semester_0_begin')->nullable();
            $table->date('semester_0_end')->nullable();
            $table->date('semester_1_begin')->nullable();
            $table->date('semester_1_end')->nullable();
            $table->date('semester_2_begin')->nullable();
            $table->date('semester_2_end')->nullable();
            $table->date('semester_3_begin')->nullable();
            $table->date('semester_3_end')->nullable();
            $table->date('semester_4_begin')->nullable();
            $table->date('semester_4_end')->nullable();
            $table->date('semester_5_begin')->nullable();
            $table->date('semester_5_end')->nullable();
            $table->date('dead_0_semester')->nullable();
            $table->date('dead_1_semester')->nullable();
            $table->date('dead_2_semester')->nullable();
            $table->date('dead_3_semester')->nullable();
            $table->date('dead_4_semester')->nullable();
            $table->date('dead_5_semester')->nullable();
            
            $table->date('first_year_begin')->nullable();
            $table->date('first_year_end')->nullable();
            $table->date('second_year_begin')->nullable();
            $table->date('second_year_end')->nullable();
            $table->date('third_year_begin')->nullable();
            $table->date('third_year_end')->nullable();
            $table->integer('jt_number')->nullable();


            //$table->date('date_entree')->nullable();
            $table->string('lieu_cabinet')->nullable();
            $table->string('tel_cabinet')->nullable();
            $table->string('email_cabinet')->nullable();
            $table->string('nom_representant')->nullable();
            $table->string('nom_maitre')->nullable();
            $table->string('prenom_maitre')->nullable();
            $table->string('email_maitre')->nullable();
            $table->string('numero_inscription_maitre')->nullable();

            $table->string('tel_maitre')->nullable();

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
