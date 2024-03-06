<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryMovement;

class RegulateInventoryResponsible extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'regulate:inventory-responsible';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'comando para actualizar en Inventories de acuerdo al ultimo responsable en movement';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Obtener todos los inventarios
        $inventories = Inventory::all();
    
        foreach ($inventories as $inventory) {
            $lastConfirmedMovement = $inventory->lastConfirmedMovement;
    
            if ($lastConfirmedMovement && $inventory->user_responsible_id !== $lastConfirmedMovement->user_responsible_id) {
                
                $inventory->update(['user_responsible_id' => $lastConfirmedMovement->user_responsible_id]);

                $this->info("Se ha actualizado el responsable exitosamente. id: {$inventory->id}");
            }
        }
    
        $this->info('Inventory responsible updated successfully.');
    }
    
    
}
