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
        Schema::create('family_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_1_id')
                  ->constrained('family_members')
                  ->onDelete('cascade');
            $table->foreignId('family_member_2_id')
                  ->constrained('family_members')
                  ->onDelete('cascade');
            $table->foreignId('relationship_type_id')
                  ->constrained('relationship_types')
                  ->onDelete('restrict');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Ensure each relationship is unique
            $table->unique(['family_member_1_id', 'family_member_2_id', 'relationship_type_id'], 'fam_rel_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_relationships');
    }
};
