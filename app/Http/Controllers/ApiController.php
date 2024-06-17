<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Viaje;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function crearUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cedula' => 'required|string|unique:usuarios,cedula|max:255',
            'numero' => 'required|integer|unique:usuarios,numero',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'clave' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $usuario = Usuario::create([
            'cedula' => $request->cedula,
            'numero' => $request->numero,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'clave' => bcrypt($request->clave), 
        ]);

        return response()->json(['message' => 'Usuario creado exitosamente', 'usuario' => $usuario], 201);
    }

    public function crearViaje(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cedulaConductor' => 'required|string|exists:usuarios,cedula',
            'cedulaPasajero' => 'required|string|exists:usuarios,cedula',
            'UbicacionPasajero' => 'required|string|max:255',
            'UbicacionDestino' => 'required|string|max:255',
            'estado' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $viaje = Viaje::create([
                'cedulaConductor' => $request->cedulaConductor,
                'cedulaPasajero' => $request->cedulaPasajero,
                'UbicacionPasajero' => $request->UbicacionPasajero,
                'UbicacionDestino' => $request->UbicacionDestino,
                'estado' => $request->estado,
            ]);

            return response()->json(['message' => 'Viaje creado exitosamente', 'viaje' => $viaje], 201);
        } catch (\Exception $e) {
            // Registrar el error para depuración
            Log::error('Error al crear el viaje: ' . $e->getMessage());
            return response()->json(['error' => 'Error al crear el viaje'], 500);
        }
    }
}
