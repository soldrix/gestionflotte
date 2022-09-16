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
        Schema::create('consommation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_voiture')->references('id')->on('voiture')->onDelete('cascade')->onUpdate('cascade');
            $table->float('montantCons');
            $table->float('litre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consommation');
    }
};

