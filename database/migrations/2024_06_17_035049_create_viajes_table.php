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
            $table->string('cedulaPasajero');
            $table->string('cedulaConductor');      
            $table->string('UbicacionPasajero');      
            $table->string('UbicacionDestino');      
            $table->timestamps();

        $table->foreign('cedulaPasajero')->references('cedula')->on('usuarios')->onDelete('cascade');
            $table->foreign('cedulaConductor')->references('cedula')->on('usuarios')->onDelete('cascade');
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
