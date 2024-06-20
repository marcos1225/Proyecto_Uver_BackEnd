<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Viaje;
use App\Models\UsuarioPasajero;
use App\Models\UsuarioConductor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function crearUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cedula' => 'nullable|string|unique:usuarios,cedula|max:255',
            'numero' => 'required|integer|unique:usuarios,numero',
            'nombre' => 'nullable|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'clave' => 'nullable|string|max:255',
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

    public function registrarNumeroCelular(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero' => 'required|integer|unique:usuarios,numero',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $usuario = Usuario::create([
            'numero' => $request->numero,
        ]);

        return response()->json(['message' => 'Número de celular registrado exitosamente', 'usuario' => $usuario], 201);
    }

    public function crearViaje(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numeroConductor' => 'required|integer|exists:usuario_conductors,numeroConductor',
            'numeroPasajero' => 'required|integer|exists:usuario_pasajeros,numeroPasajero',
            'UbicacionPasajero' => 'required|string|max:255',
            'UbicacionDestino' => 'required|string|max:255',
            'estado' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $viaje = Viaje::create([
                'numeroConductor' => $request->numeroConductor,
                'numeroPasajero' => $request->numeroPasajero,
                'UbicacionPasajero' => $request->UbicacionPasajero,
                'UbicacionDestino' => $request->UbicacionDestino,
                'estado' => $request->estado,
            ]);

            return response()->json(['message' => 'Viaje creado exitosamente', 'viaje' => $viaje], 201);
        } catch (\Exception $e) {
            // Registrar el error para depuración
            Log::error('Error al crear el viaje: ' . $e->getMessage());
            return response()->json(['error' => 'Error al crear el viaje', 'details' => $e->getMessage()]);
        }
    }

    public function actualizarUsuarioPorNumero(Request $request, $numero)
{
    $validator = Validator::make($request->all(), [
        'cedula' => 'nullable|string|max:255|unique:usuarios,cedula,' . $numero . ',numero',
        'nombre' => 'nullable|string|max:255',
        'apellido' => 'nullable|string|max:255',
        'clave' => 'nullable|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    try {
        $usuario = Usuario::where('numero', $numero)->first();

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $usuario->update([
            'cedula' => $request->input('cedula', $usuario->cedula),
            'nombre' => $request->input('nombre', $usuario->nombre),
            'apellido' => $request->input('apellido', $usuario->apellido),
            'clave' => $request->filled('clave') ? bcrypt($request->input('clave')) : $usuario->clave,
        ]);

        return response()->json(['message' => 'Usuario actualizado exitosamente', 'usuario' => $usuario], 200);
    } catch (\Exception $e) {
        Log::error('Error al actualizar el usuario: ' . $e->getMessage(), [
            'numero' => $numero,
            'request_data' => $request->all()
        ]);
        return response()->json(['error' => 'Error al actualizar el usuario', 'details' => $e->getMessage()], 500);
    }
}
public function verificarNumeroRegistrado($numero)
    {
        $usuario = Usuario::where('numero', $numero)->first();

        if ($usuario) {
            return response()->json(['message' => 'Número de teléfono registrado', 'usuario' => $usuario], 200);
        } else {
            return response()->json(['message' => 'Número de teléfono no registrado'], 404);
        }
    }
    public function crearYRegistrarUsuarioPasajero(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cedula' => 'nullable|string|unique:usuarios,cedula|max:255',
            'numero' => 'required|integer|unique:usuarios,numero',
            'nombre' => 'nullable|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'clave' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            
            $usuario = Usuario::create([
                'cedula' => $request->cedula,
                'numero' => $request->numero,
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'clave' => bcrypt($request->clave),
            ]);

            Log::info('Usuario creado: ' . $usuario->numero);

           
            $usuarioPasajero = UsuarioPasajero::create([
                'numeroPasajero' => $usuario->numero,
            ]);

            Log::info('UsuarioPasajero creado: ' . $usuarioPasajero->numeroPasajero);

            return response()->json([
                'message' => 'Usuario y UsuarioPasajero creados exitosamente',
                'usuario' => $usuario,
                'usuarioPasajero' => $usuarioPasajero
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al crear el usuario y el usuario pasajero: ' . $e->getMessage());
            return response()->json(['error' => 'Error al crear el usuario y el usuario pasajero', 'details' => $e->getMessage()], 500);
        }
    }
    
}
