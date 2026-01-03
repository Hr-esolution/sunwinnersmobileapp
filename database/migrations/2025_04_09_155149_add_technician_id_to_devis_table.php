<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTechnicianIdToDevisTable extends Migration
{
    public function up()
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->unsignedBigInteger('technician_id')->nullable(); // Ajouter technician_id
            $table->foreign('technician_id')->references('id')->on('technicians')->onDelete('set null'); // Clé étrangère vers technicians

        });
    }

    public function down()
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->dropForeign(['technician_id']); // Supprimer la clé étrangère
            $table->dropColumn('technician_id'); // Supprimer la colonne technician_id
        });
    }
}