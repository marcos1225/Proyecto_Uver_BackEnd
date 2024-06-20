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
        $user = [
            'cedula' => '504390996',
            'numero' => 63549134,
            'nombre' => 'Jose',
            'apellido' => 'Torres',
            'clave' => bcrypt('perro123'),
        ];

        $response = $this->postJson('/api/usuarios', $user);

        $response->assertStatus(201)
                ->assertJson([
                    'message' => 'Usuario creado exitosamente',
                    'usuario' => [
                        'cedula' => $user['cedula'],
                        'numero' => $user['numero'],
                        'nombre' => $user['nombre'],
                        'apellido' => $user['apellido'],
                    ],
                ]);

        $this->assertDatabaseHas('usuarios', [
            'cedula' => $user['cedula'],
            'numero' => $user['numero'],
            'nombre' => $user['nombre'],
            'apellido' => $user['apellido'],
        ]);
    }

    public function testCrearUsuarioDuplicado()
    {
        // Crear un usuario inicial
        $usuario = Usuario::create([
            'cedula' => '1234567890',
            'numero' => 87654325,
            'nombre' => 'Luis',
            'apellido' => 'Guzman',
            'clave' => bcrypt('clavesecreta'),
        ]);

        // Intentar crear un usuario con el mismo numero de celular
        $user2 = [
            'cedula' => '93848393',
            'numero' => 87654325,
            'nombre' => 'Adrian',
            'apellido' => 'Lopez',
            'clave' => 'clavesecreta2',
        ];

        $response = $this->postJson('/api/usuarios', $user2);

        $response->assertStatus(400)
                 ->assertJsonStructure([
                     'errors' => [
                         'numero',
                     ],
                 ]);
    }
    
    public function testRegistrarNumeroCelularExitosamente()
    {
        $user = [
            'numero' => 63549134,
        ];

        $response = $this->postJson('/api/registrar-numero-celular', $user);

        $response->assertStatus(201)
                ->assertJson([
                    'message' => 'Número de celular registrado exitosamente',
                    'usuario' => [
                        'numero' => $user['numero'],
                    ],
                ]);

        $this->assertDatabaseHas('usuarios', [
            'numero' => $user['numero'],
        ]);
    }

    public function testRegistrarNumeroCelularDuplicado()
    {
        // Crear un usuario inicial
        $usuario = Usuario::create([
            'cedula' => '1234567890',
            'numero' => 12345678,
            'nombre' => 'Rosa',
            'apellido' => 'Perez',
            'clave' => bcrypt('clavesecreta'),
        ]);

        // Intentar registrar un número de celular que ya existe
        $user2 = [
            'numero' => 12345678,
        ];

        $response = $this->postJson('/api/registrar-numero-celular', $user2);

        $response->assertStatus(400)
                 ->assertJsonStructure([
                     'errors' => [
                         'numero',
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
            'idMarca' => $marca->id,  
            'idModelo' => $modelo->id,  
        ]);

        // Crear pasajero
        $pasajero = Usuario::create([
            'cedula' => '1234567890',
            'numero' => 12345678,
            'nombre' => 'Marcos',
            'apellido' => 'Gonzalez',
            'clave' => bcrypt('securepassword'),
        ]);

        UsuarioPasajero::create([
            'numeroPasajero' => $pasajero->numero,
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
            'numeroConductor' => $usuarioConductor->numero,
            'idLicencia' => $licencia->id,
            'idVehiculo' => $vehiculo->matricula, 
        ]);

        // Datos del viaje
        $payload = [
            'numeroPasajero' => $pasajero->numero,
            'numeroConductor' => $conductor->numeroConductor,
            'UbicacionPasajero' => 'Ubicacion A',
            'UbicacionDestino' => 'Ubicacion B',
            'estado' => true,
        ];

        $response = $this->postJson('/api/viajes', $payload);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Viaje creado exitosamente',
                     'viaje' => [
                         'numeroPasajero' => $payload['numeroPasajero'],
                         'numeroConductor' => $payload['numeroConductor'],
                         'UbicacionPasajero' => $payload['UbicacionPasajero'],
                         'UbicacionDestino' => $payload['UbicacionDestino'],
                         'estado' => $payload['estado'],
                     ],
                 ]);

        $this->assertDatabaseHas('viajes', [
            'numeroPasajero' => $payload['numeroPasajero'],
            'numeroConductor' => $payload['numeroConductor'],
            'UbicacionPasajero' => $payload['UbicacionPasajero'],
            'UbicacionDestino' => $payload['UbicacionDestino'],
            'estado' => $payload['estado'],
        ]);
    }

    public function testActualizarUsuarioPorNumeroExitosamente()
{
    $usuario = Usuario::create([
        'cedula' => '1234567890',
        'numero' => 12345678,
        'nombre' => 'Luis',
        'apellido' => 'Gomez',
        'clave' => bcrypt('clavesecreta'),
    ]);

    $data = [
        'cedula' => '0987654321',
        'nombre' => 'Juan',
        'apellido' => 'Perez',
        'clave' => 'nuevaclave',
    ];

    $response = $this->putJson('/api/actualizar-usuario/' . $usuario->numero, $data);

    $response->assertStatus(200)
             ->assertJson([
                 'message' => 'Usuario actualizado exitosamente',
                 'usuario' => [
                     'cedula' => $data['cedula'],
                     'nombre' => $data['nombre'],
                     'apellido' => $data['apellido'],
                 ],
             ]);

    $this->assertDatabaseHas('usuarios', [
        'numero' => $usuario->numero,
        'cedula' => $data['cedula'],
        'nombre' => $data['nombre'],
        'apellido' => $data['apellido'],
    ]);
}
public function testVerificarSiExisteElUsuario()
    {
        $usuario = Usuario::create([
            'cedula' => '1234567890',
            'numero' => 12345678,
            'nombre' => 'Luis',
            'apellido' => 'Gomez',
            'clave' => bcrypt('clavesecreta'),
        ]);

        $response = $this->getJson('/api/verificar-numero-registrado/' . $usuario->numero);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Número de teléfono registrado',
                     'usuario' => [
                         'cedula' => $usuario->cedula,
                         'numero' => $usuario->numero,
                         'nombre' => $usuario->nombre,
                         'apellido' => $usuario->apellido,
                     ],
                 ]);
    }
    public function testCrearYRegistrarUsuarioPasajeroExitosamente()
    {
        $user = [
            'cedula' => '504390996',
            'numero' => 63549134,
            'nombre' => 'Jose',
            'apellido' => 'Torres',
            'clave' => 'perro123',
        ];

        $response = $this->postJson('/api/crear-registrar-usuario-pasajero', $user);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Usuario y UsuarioPasajero creados exitosamente',
                     'usuario' => [
                         'cedula' => $user['cedula'],
                         'numero' => $user['numero'],
                         'nombre' => $user['nombre'],
                         'apellido' => $user['apellido'],
                     ],
                     'usuarioPasajero' => [
                         'numeroPasajero' => $user['numero'],
                     ],
                 ]);

        $this->assertDatabaseHas('usuarios', [
            'cedula' => $user['cedula'],
            'numero' => $user['numero'],
            'nombre' => $user['nombre'],
            'apellido' => $user['apellido'],
        ]);

        $this->assertDatabaseHas('usuario_pasajeros', [
            'numeroPasajero' => $user['numero'],
        ]);
    }
    public function testMostrarDatosViajeExitosamente()
{
    // Crear modelo
    $modelo = Modelo::create(['modelo' => 2024]);
    
    // Crear marca
    $marca = Marca::create(['marca' => 'Honda']);
    
    // Crear licencia
    $licencia = Licencia::create([
        'tipo' => 'B1',
        'fechaVencimiento' => '2025-12-31',
    ]);
    
    // Crear vehiculo utilizando los IDs recién creados
    $vehiculo = Vehiculo::create([
        'matricula' => 'ABC123',
        'idMarca' => $marca->id,  
        'idModelo' => $modelo->id,  
    ]);
    
    // Crear pasajero
    $pasajero = Usuario::create([
        'cedula' => '1234567890',
        'numero' => 12345678,
        'nombre' => 'Marcos',
        'apellido' => 'Gonzalez',
        'clave' => bcrypt('securepassword'),
    ]);
    
    UsuarioPasajero::create(['numeroPasajero' => $pasajero->numero]);
    
    // Crear conductor
    $usuarioConductor = Usuario::create([
        'cedula' => '0987654321',
        'numero' => 87654321,
        'nombre' => 'Juan',
        'apellido' => 'Perez',
        'clave' => bcrypt('securepassword2'),
    ]);
    
    $conductor = UsuarioConductor::create([
        'numeroConductor' => $usuarioConductor->numero,
        'idLicencia' => $licencia->id,
        'idVehiculo' => $vehiculo->matricula, 
    ]);
    
    // Crear el viaje
    $viaje = Viaje::create([
        'numeroConductor' => $conductor->numeroConductor, 
        'numeroPasajero' => $pasajero->numero, 
        'UbicacionPasajero' => 'Ubicacion A', 
        'UbicacionDestino' => 'Ubicacion B', 
        'estado' => true
    ]);
    
    // Asegurarse de que el viaje tiene un idViaje válido
    $this->assertNotNull($viaje->idViaje, 'El idViaje no debería ser nulo');

    // Verificar que el viaje se ha creado en la base de datos
    $this->assertDatabaseHas('viajes', ['idViaje' => $viaje->idViaje]);

    // Probar el endpoint
    $response = $this->getJson('/api/mostrarViaje/' . $viaje->idViaje);

    $response->assertStatus(200)
             ->assertJson(['viaje' => [
                 'idViaje' => $viaje->idViaje,
                 'numeroConductor' => $viaje->numeroConductor,
                 'numeroPasajero' => $viaje->numeroPasajero,
                 'UbicacionPasajero' => $viaje->UbicacionPasajero,
                 'UbicacionDestino' => $viaje->UbicacionDestino,
                 'estado' => $viaje->estado,
             ]]);
}

    

}
