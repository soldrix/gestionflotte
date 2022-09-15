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
        Schema::create('assurance', function (Blueprint $table) {
            $table->id();
            $table->string('nomAssu');
            $table->foreignId('id_voiture')->references('id')->on('voiture')->onDelete('cascade')->onUpdate('cascade');
            $table->date('debutAssu');
            $table->float('frais');
            $table->date('finAssu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assurance');
    }
};


