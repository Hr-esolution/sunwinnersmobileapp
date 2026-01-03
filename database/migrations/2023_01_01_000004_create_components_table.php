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
        Schema::create('composants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('reference');
            $table->decimal('unit_price', 10, 2);
            $table->foreignId('technician_id')->constrained()->onDelete('cascade');
            $table->string('manufacturer')->nullable();
            $table->integer('warranty_period')->nullable(); // in months
            $table->json('certifications')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('composants');
    }
};