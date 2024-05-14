<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inv\Inventory;

class SyncInventory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:inventory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix de la tabla Inventory a que quede el place con el último movimiento confirmado (place_id).';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Obtener todos los inventarios
        $inventories = Inventory::all();

        // Contador para el total de movimientos actualizados
        $totalMovementsUpdated = 0;

        // Iterar sobre cada inventario
        foreach ($inventories as $inventory) {
            // Obtener el último movimiento confirmado
            $lastConfirmedMovement = $inventory->lastConfirmedMovement;

            // Verificar si existe un último movimiento confirmado
            if ($lastConfirmedMovement) {
                // Comparar el lugar del último movimiento con el lugar actual del inventario
                if ($lastConfirmedMovement->place_id !== $inventory->place_id) {
                    // Actualizar el lugar del inventario con el lugar del último movimiento confirmado
                    $inventory->update(['place_id' => $lastConfirmedMovement->place_id]);

                    // Incrementar el contador de movimientos actualizados
                    $totalMovementsUpdated++;

                    // Mostrar por pantalla el ID del movimiento actualizado
                    $this->info("Se ha actualizado el lugar del inventario {$inventory->id}. Nuevo lugar: {$lastConfirmedMovement->place_id}");
                }
            }
        }

        // Mostrar por pantalla el total de movimientos actualizados
        $this->info("Total de movimientos actualizados: {$totalMovementsUpdated}");

        // Devolver el estado de éxito del comando
        return Command::SUCCESS;
    }
}
