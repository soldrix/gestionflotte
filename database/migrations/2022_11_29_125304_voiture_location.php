<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VoitureLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location', function (Blueprint $table) {
            $table->id();
            $table->date('dateDebut');
            $table->date('dateFin');
            $table->float('montant');
            $table->foreignId('id_voiture')->nullable()->references('id')->on('voiture')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_users')->nullable()->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location');
    }
}
