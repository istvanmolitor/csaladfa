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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Alapadatok
            $table->string('first_name');
            $table->string('last_name');
            $table->string('maiden_name')->nullable();       // leánykori név
            $table->enum('gender', ['male', 'female', 'other'])->nullable();

            // Születés
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();

            // Halál
            $table->date('death_date')->nullable();
            $table->string('death_place')->nullable();

            // Egyéb
            $table->string('nationality')->nullable();
            $table->string('occupation')->nullable();        // foglalkozás
            $table->text('bio')->nullable();                 // életrajz / leírás
            $table->string('profile_photo_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
