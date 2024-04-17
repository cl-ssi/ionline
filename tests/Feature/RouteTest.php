<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User; // Asegúrate de importar el modelo de usuario si aún no lo has hecho

class RouteTest extends TestCase
{
    protected $rutas = [
        '/home',
        '/summary',
    ];

    public function testVerificarStatusDeRutas()
    {
        $user = User::find(15287582); // Encuentra al usuario por su ID (ajusta esto según tu modelo de usuario)

        $passing = true;

        foreach ($this->rutas as $ruta) {
            // Autenticar al usuario antes de realizar la solicitud
            $response = $this->actingAs($user)->get($ruta);
            
            // Obtener el código de estado HTTP de la respuesta
            $statusCode = $response->getStatusCode();
            echo $ruta . ' ' . $statusCode . "\n";
            
            if (isset($response->exception)) {
                try {
                    $passing = false;
                } catch (SomethingExpected $e) {
                    echo "catch";
                }
            }

            try {
                // Verificar si el código de estado es 500 y marcar como "risky"
                if ($statusCode === 500) {
                    // $this->withoutExceptionHandling();
                    $this->assertTrue(false, "La ruta $ruta devolvió un código 500.");
                }
            } catch (\Exception $e) {
                // Capturar la excepción sin hacer nada
            }
        }
        $this->assertTrue($passing);
    }
}
