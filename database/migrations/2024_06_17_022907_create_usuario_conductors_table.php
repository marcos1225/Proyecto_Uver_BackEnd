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
        Schema::create('usuario_conductors', function (Blueprint $table) {
            $table->id('idConductor');
            $table->string('cedulaConductor')->unique();
            $table->unsignedBigInteger('idLicencia');
            $table->unsignedBigInteger('idVehiculo');
            $table->foreign('cedulaConductor')->references('cedula')->on('usuarios')->onDelete('cascade');
            $table->foreign('idLicencia')->references('idLicencia')->on('licencias')->onDelete('cascade');
            $table->foreign('idVehiculo')->references('idVehiculo')->on('vehiculos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_conductors');
    }
};
