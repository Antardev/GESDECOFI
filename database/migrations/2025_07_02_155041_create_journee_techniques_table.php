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
        Schema::create('journee_techniques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stagiaire_id');
            $table->foreignId('affiliation_order_id');

            $table->string('affiliation_order');
            $table->string('jt_name');
            $table->string('jt_description');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('jt_location')->nullable();
            $table->integer('jt_year')->nullable();
            $table->integer('nb_hour')->nullable();
            $table->string('rapport_path')->nullable();
            //$table->enum('year', ['1', '2', '3'])->nullable();
            $table->enum('semester', ['1', '2', '3', '4', '5', '6'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journee_techniques');
    }
};
