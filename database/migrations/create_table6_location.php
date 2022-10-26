<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocation extends Migration
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
            $table->dateTime('dateDebut');
            $table->dateTime('dateFin');
            $table->foreignId('id_voiture')->nullable()->references('id')->on('voiture')->onDelete('null')->onUpdate('null');
            $table->foreignId('id_agence')->nullable()->references('id')->on('agence')->onDelete('null')->onUpdate('null');
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
