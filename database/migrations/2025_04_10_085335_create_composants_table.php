<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComposantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('composants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('reference')->nullable();
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->unsignedBigInteger('technician_id');
            $table->string('manufacturer')->nullable();
            $table->integer('warranty_period')->nullable();
            $table->string('certifications')->nullable();
            $table->timestamps();

            // Définir la relation avec le technicien
            $table->foreign('technician_id')->references('id')->on('technicians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('composants');
    }
}