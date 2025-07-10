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
        Schema::create('controleur_assistants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('controleur_id');
            $table->string('name');
            $table->string('first_name');
            $table->string('picture_path');
            $table->date('birth_date');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('country_contr');
            $table->string('specialty')->nullable();
            $table->string('hire_date')->nullable();
            $table->string('cnss_number')->nullable();
            $table->string('diploma')->nullable();
            //$table->string('roles')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('controleur_assistants');
    }
};
