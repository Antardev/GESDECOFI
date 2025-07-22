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
            $table->string('full_name');
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('picture_path')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            //$table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('country_contr');
            //$table->string('specialty')->nullable();
            $table->string('hire_date')->nullable();
            $table->string('titre')->nullable();
            $table->string('fonction')->nullable();
            $table->string('cnss_number')->nullable();
            $table->string('diploma')->nullable();

            $table->boolean('activated')->default(0);

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
