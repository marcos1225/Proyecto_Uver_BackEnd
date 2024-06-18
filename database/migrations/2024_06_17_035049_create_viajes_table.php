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
        Schema::create('viajes', function (Blueprint $table) {
            $table->id('idViaje');
            $table->integer('numeroPasajero');
            $table->integer('numeroConductor');      
            $table->string('UbicacionPasajero');      
            $table->string('UbicacionDestino'); 
            $table->boolean('estado');     
            $table->timestamps();

        $table->foreign('numeroPasajero')->references('numero')->on('usuarios')->onDelete('cascade');
            $table->foreign('numeroConductor')->references('numero')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viajes');
    }
};
