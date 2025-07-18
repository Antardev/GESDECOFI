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
        Schema::create('jt_sub_domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_domain_id');
            $table->foreignId('stagiaire_id');
            $table->string('sub_domain_name');
            $table->foreignId('journee_technique_id');
            $table->integer('nb_hour');
            $table->integer('year');
            $table->integer('semester');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jt_sub_domains');
    }
};
