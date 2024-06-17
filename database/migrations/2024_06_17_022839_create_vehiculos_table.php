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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->string('matricula')->primary();
            $table->unsignedBigInteger('idMarca');
            $table->unsignedBigInteger('idModelo');
            $table->foreign('idMarca')->references('idMarca')->on('marcas')->onDelete('cascade');
            $table->foreign('idModelo')->references('idModelo')->on('modelos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
