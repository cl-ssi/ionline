<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inv\Inventory;

class CheckUserUsingDiscrepancies extends Command
{
    protected $signature = 'inventories:check-user-discrepancies';
    protected $description = 'Verifica discrepancias entre user_using_id en la tabla inventories y el último movimiento confirmado.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $discrepancyCount = 0;
        
        // Obtén todos los inventarios
        $inventories = Inventory::all();

        foreach ($inventories as $inventory) {
            // Obtén el último movimiento confirmado
            $lastConfirmedMovement = $inventory->lastConfirmedMovement;

            if ($lastConfirmedMovement) {
                $inventoryUserUsingId = $inventory->user_using_id;
                $movementUserUsingId = $lastConfirmedMovement->user_using_id;

                // Verifica si hay discrepancia
                if ($inventoryUserUsingId !== $movementUserUsingId) {
                    $this->info("Discrepancia encontrada en el inventario ID {$inventory->id}: 
                                Inventario user_using_id = {$inventoryUserUsingId}, 
                                Movimiento user_using_id = {$movementUserUsingId}");
                    $discrepancyCount++;

                    // Mueve el valor de user_using_id del movimiento al inventario
                    $inventory->user_using_id = $movementUserUsingId;
                    $inventory->save();

                    $this->info("Actualizado el inventario ID {$inventory->id} con user_using_id = {$movementUserUsingId}");
                }
            } else {
                // $this->info("No se encontró un movimiento confirmado para el inventario ID {$inventory->id}");
            }
        }

        $this->info("Número total de discrepancias encontradas: {$discrepancyCount}");
        $this->info('Proceso completado.');
    }
}
