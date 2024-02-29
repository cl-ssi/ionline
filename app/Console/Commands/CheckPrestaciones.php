<?php

namespace App\Console\Commands;

use App\Models\Indicators\Prestacion;
use Illuminate\Console\Command;

class CheckPrestaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:prestaciones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $prestaciones = Prestacion::all();
        // Por cada prestación eliminar de la descripción todos los dobles espacios que hayan
        foreach ($prestaciones as $prestacion) {
            $prestacion->descripcion = preg_replace('/\s+/', ' ', $prestacion->descripcion);
        }
        // por cada prestación buscar en la descripción la ocurrencia de " -[caracter]" y reemplazar por " - [caracter]"
        foreach ($prestaciones as $prestacion) {
            $prestacion->descripcion = preg_replace('/\s-\w/', ' - $1', $prestacion->descripcion);
        }
        // por cada prestación buscar en la descripción la ocurrencia de "[caracter]- " y reemplazar por "[caracter] - "
        foreach ($prestaciones as $prestacion) {
            $prestacion->descripcion = preg_replace('/\w-\s/', '$1 - ', $prestacion->descripcion);
        }
        // imprimir en pantalla solo aquellas prestaciones que hayan sido modificadas
        foreach ($prestaciones as $prestacion) {
            if ($prestacion->isDirty()) {
                echo $prestacion->id_prestacion . ': ' .$prestacion->descripcion . "\n";
            }
        }
        $prestacion->save();
        return Command::SUCCESS;
    }
}
