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
        Schema::create('demande_attestations', function (Blueprint $table) {
            $table->id();

            $table->string('civilite');
            $table->string('numerodemande');
            $table->string('matriculestagiaire')->nullable();
            $table->string('nomstagiaire');
            $table->string('prenomstagiaire');
            $table->string('lieunaissance');
            $table->string('nationalite');
            $table->string('adresse');
            $table->date('datenaissance');
            $table->string('phonecontact');
            $table->string('email')->unique();

            // Infos sur le stage
            $table->date('datedebutstage');
            $table->date('datefinstage');
            $table->string('prenomcontrolleurstage');
            $table->string('prenomaitrestage');
            $table->string('orderaffimaitstage');
            $table->string('numeroaffimaitstage');
            $table->date('dateaffimaitstage');
            $table->string('raisonsociastructure');
            $table->string('nomcontrolleurstage')->nullable();
            $table->string('nomaitrestage')->nullable();
            $table->string('ordreaffilistructure');
            $table->string('numeroaffilistructure');
            $table->date('dateaffilistructure');

            // Obligations : chemins des fichiers
            $table->json('conditions')->nullable();
            $table->json('rapports')->nullable();
            $table->json('journees')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_attestations');
    }
};
