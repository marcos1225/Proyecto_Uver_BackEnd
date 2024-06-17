<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Modelo;
use App\Models\Usuario;
use App\Models\UsuarioConductor;
use App\Models\Licencia;
use App\Models\UsuarioPasajero;
use App\Models\Viaje;
use App\Models\Vehiculo;
use App\Models\Marca;

class UverTest extends TestCase
{
    use RefreshDatabase;

    public function testCrearUsuarioExitosamente()
    {
        $payload = [
            'cedula' => '1234567890',
            'numero' => 12345678,
            'nombre' => 'Carlos',
            'apellido' => 'Martinez',
            'clave' => 'securepassword',
        ];

        $response = $this->postJson('/api/usuarios', $payload);

        $response->assertStatus(201)
                ->assertJson([
                    'message' => 'Usuario creado exitosamente',
                    'usuario' => [
                        'cedula' => $payload['cedula'],
                        'numero' => $payload['numero'],
                        'nombre' => $payload['nombre'],
                        'apellido' => $payload['apellido'],
                    ],
                ]);

        $this->assertDatabaseHas('usuarios', [
            'cedula' => $payload['cedula'],
            'numero' => $payload['numero'],
            'nombre' => $payload['nombre'],
            'apellido' => $payload['apellido'],
        ]);
    }

    public function testCrearUsuarioDuplicado()
    {
        // Crear un usuario inicial
        $usuario = Usuario::create([
            'cedula' => '1234567890',
            'numero' => 123456789,
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'clave' => bcrypt('securepassword1'),
        ]);

        // Intentar crear un usuario con el mismo cedula 
        $payload = [
            'cedula' => '1234567890',
            'numero' => 987654321,
            'nombre' => 'Carlos',
            'apellido' => 'Martinez',
            'clave' => 'securepassword2',
        ];

        $response = $this->postJson('/api/usuarios', $payload);

        $response->assertStatus(400)
                 ->assertJsonStructure([
                     'errors' => [
                         'cedula',
                     ],
                 ]);
    }

    public function testCrearViajeExitosamente()
    {
        // Crear modelo
        $modelo = Modelo::create([
            'modelo' => 2024
        ]);
        
        // Crear marca
        $marca = Marca::create([
            'marca' => 'Honda'
        ]);

        // Crear licencia
        $licencia = Licencia::create([
            'tipo' => 'B1',
            'fechaVencimiento' => '2025-12-31',
        ]);

        // Crear vehiculo utilizando los IDs recién creados
        $vehiculo = Vehiculo::create([
            'matricula' => 'ABC123',
            'idMarca' => $marca->id,  // Asegurándonos de obtener el ID correcto
            'idModelo' => $modelo->id,  // Asegurándonos de obtener el ID correcto
        ]);

        // Crear pasajero
        $pasajero = Usuario::create([
            'cedula' => '1234567890',
            'numero' => 12345678,
            'nombre' => 'Carlos',
            'apellido' => 'Martinez',
            'clave' => bcrypt('securepassword'),
        ]);

        UsuarioPasajero::create([
            'cedulaPasajero' => $pasajero->cedula,
        ]);

        // Crear conductor
        $usuarioConductor = Usuario::create([
            'cedula' => '0987654321',
            'numero' => 87654321,
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'clave' => bcrypt('securepassword2'),
        ]);

        $conductor = UsuarioConductor::create([
            'cedulaConductor' => $usuarioConductor->cedula,
            'idLicencia' => $licencia->id,
            'idVehiculo' => $vehiculo->matricula,  // Asegúrate de que se está proporcionando 'idVehiculo'
        ]);

        // Datos del viaje
        $payload = [
            'cedulaPasajero' => $pasajero->cedula,
            'cedulaConductor' => $conductor->cedulaConductor,
            'UbicacionPasajero' => 'Ubicacion A',
            'UbicacionDestino' => 'Ubicacion B',
            'estado' => true,
        ];

        $response = $this->postJson('/api/viajes', $payload);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Viaje creado exitosamente',
                     'viaje' => [
                         'cedulaPasajero' => $payload['cedulaPasajero'],
                         'cedulaConductor' => $payload['cedulaConductor'],
                         'UbicacionPasajero' => $payload['UbicacionPasajero'],
                         'UbicacionDestino' => $payload['UbicacionDestino'],
                         'estado' => $payload['estado'],
                     ],
                 ]);

        $this->assertDatabaseHas('viajes', [
            'cedulaPasajero' => $payload['cedulaPasajero'],
            'cedulaConductor' => $payload['cedulaConductor'],
            'UbicacionPasajero' => $payload['UbicacionPasajero'],
            'UbicacionDestino' => $payload['UbicacionDestino'],
            'estado' => $payload['estado'],
        ]);
    }
}
