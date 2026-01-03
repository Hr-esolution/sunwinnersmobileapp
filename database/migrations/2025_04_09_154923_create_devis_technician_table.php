<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevisTechnicianTable extends Migration
{
    public function up()
    {
        Schema::create('devis_technician', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('devis_id');
            $table->unsignedBigInteger('technician_id');
            $table->timestamps();

            // Clé étrangère pour les devis
            $table->foreign('devis_id')->references('id')->on('devis')->onDelete('cascade');
            // Clé étrangère pour les techniciens
            $table->foreign('technician_id')->references('id')->on('technicians')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('devis_technician');
    }
}