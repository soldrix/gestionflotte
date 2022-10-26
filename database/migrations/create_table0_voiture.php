<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voiture', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('marque');
            $table->string('model');
            $table->string('carburant');
            $table->string('circulation');
            $table->string('immatriculation');
            $table->string('statut');
            $table->integer('puissance');
            $table->text('image');
            $table->string('type');
            $table->integer('nbPorte');
            $table->integer('nbPlace');
            $table->float('prix');
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
        Schema::dropIfExists('voiture');
    }
};
