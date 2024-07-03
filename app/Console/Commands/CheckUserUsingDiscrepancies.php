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
        $discrepancyCountDirect = 0;
        $discrepancyCountRelation = 0;
        
        $discrepancyIdsDirect = [];
        $discrepancyIdsRelation = [];

        // Obtén todos los inventarios
        $inventories = Inventory::all();

        foreach ($inventories as $inventory) {
            // Primer método: consulta directa
            $lastConfirmedMovementDirect = $inventory->movements()
                                                    ->whereNotNull('reception_date')
                                                    ->orderBy('reception_date', 'desc')
                                                    ->orderBy('id', 'desc')
                                                    ->first();

            if ($lastConfirmedMovementDirect) {
                $inventoryUserUsingIdDirect = $inventory->user_using_id;
                $movementUserUsingIdDirect = $lastConfirmedMovementDirect->user_using_id;

                if ($inventoryUserUsingIdDirect !== $movementUserUsingIdDirect) {
                    $discrepancyIdsDirect[] = $inventory->id;
                    $discrepancyCountDirect++;
                }
            }

            // Segundo método: usando la relación
            $lastConfirmedMovementRelation = $inventory->lastConfirmedMovement;

            if ($lastConfirmedMovementRelation) {
                $inventoryUserUsingIdRelation = $inventory->user_using_id;
                $movementUserUsingIdRelation = $lastConfirmedMovementRelation->user_using_id;

                if ($inventoryUserUsingIdRelation !== $movementUserUsingIdRelation) {
                    $discrepancyIdsRelation[] = $inventory->id;
                    $discrepancyCountRelation++;
                }
            }
        }

        // Comparar los IDs de discrepancia
        $differences = array_diff($discrepancyIdsDirect, $discrepancyIdsRelation);

        $this->info("Número total de discrepancias encontradas usando consulta directa: {$discrepancyCountDirect}");
        $this->info("Número total de discrepancias encontradas usando relación: {$discrepancyCountRelation}");

        if (!empty($differences)) {
            $this->info("IDs diferentes encontrados: " . implode(', ', $differences));
        } else {
            $this->info("No se encontraron diferencias entre los dos métodos.");
        }

        $this->info('Proceso completado.');
    }
}
