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
        Schema::create('entretiens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_voiture')->references('id')->on('voiture')->onDelete('cascade')->onUpdate('cascade');
            $table->string('typeEnt',150);
            $table->date('dateEnt');
            $table->float('montantEnt');
            $table->string('garageEnt',150);
            $table->text('noteEnt')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entretiens');
    }
};

