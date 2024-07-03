<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryUser;

class AssignUsersToInventories extends Command
{
    protected $signature = 'inventories:assign-users';
    protected $description = 'Asigna el usuario usando el inventario al modelo InventoryUser basado en el último movimiento confirmado.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Obtén todos los inventarios
        $inventories = Inventory::all();

        foreach ($inventories as $inventory) {
            // Obtén el último movimiento confirmado
            $lastConfirmedMovement = $inventory->movements()
                                               ->whereNotNull('reception_date')
                                               ->orderBy('reception_date', 'desc')
                                               ->first();

            if ($lastConfirmedMovement) {
                $userId = $inventory->user_using_id;

                // Verifica si ya está asignado
                $existingAssignment = InventoryUser::where('inventory_id', $inventory->id)
                                                   ->where('user_id', $userId)
                                                   ->first();

                if (!$existingAssignment) {
                    // Crea una nueva asignación
                    InventoryUser::create([
                        'inventory_id' => $inventory->id,
                        'user_id' => $userId,
                    ]);

                    $this->info("Asignado usuario ID {$userId} al inventario ID {$inventory->id}");
                } else {
                    $this->info("El usuario ID {$userId} ya está asignado al inventario ID {$inventory->id}");
                }
            } else {
                $this->info("No se encontró un movimiento confirmado para el inventario ID {$inventory->id}");
            }
        }

        $this->info('Proceso completado.');
    }
}
