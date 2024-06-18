<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::post('/usuarios', [ApiController::class, 'crearUsuario']);
Route::post('/viajes', [ApiController::class, 'crearViaje']);
Route::post('/registrar-numero-celular', [ApiController::class, 'registrarNumeroCelular']);
Route::put('/actualizar-usuario/{numero}', [ApiController::class, 'actualizarUsuarioPorNumero']);
