<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevisResponseComposantTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devis_response_composant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('devis_response_id')->constrained()->onDelete('cascade');
            $table->foreignId('composant_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis_response_composant');
    }
}