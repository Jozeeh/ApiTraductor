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
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id('idFavoritos');
            $table->unsignedBigInteger('fkIdUsuario');
            // campo - id - tabla (Llave foranea de plato)
            $table->foreign('fkIdUsuario')->references('id')->on('users');
            $table->string('Palabra');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoritos');
    }
};
