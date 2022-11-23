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
        Schema::create('reparations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_voiture')->nullable()->references('id')->on('voiture')->onDelete('cascade')->onUpdate('cascade');
            $table->string('typeRep',150);
            $table->date('dateRep');
            $table->float('montantRep');
            $table->string('garageRep',150);
            $table->text('noteRep')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reparation');
    }
};

