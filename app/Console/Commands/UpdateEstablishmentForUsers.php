<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;

class UpdateEstablishmentForUsers extends Command
{
    // El nombre y la descripción del comando
    protected $signature = 'users:update-establishment';
    protected $description = 'Actualiza el establishment_id de los usuarios que no lo tienen asignado, basándose en su organizational_unit_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Encuentra todos los usuarios con establishment_id nulo y organizational_unit_id no nulo
        $users = User::whereNull('establishment_id')
                    ->whereNotNull('organizational_unit_id')
                    ->get();

        $this->info("Usuarios encontrados: " . $users->count());

        // Recorre cada usuario
        foreach ($users as $user) {
            // Busca la unidad organizativa del usuario
            $organizationalUnit = OrganizationalUnit::find($user->organizational_unit_id);

            // Si la unidad organizativa tiene un establishment_id, lo asigna al usuario
            if ($organizationalUnit && $organizationalUnit->establishment_id) {
                $user->establishment_id = $organizationalUnit->establishment_id;
                $user->save();

                $this->info("Usuario {$user->id} actualizado con establishment_id: {$organizationalUnit->establishment_id}");
            } else {
                $this->warn("No se pudo actualizar el usuario {$user->id} porque su unidad organizativa no tiene establecimiento asignado.");
            }
        }

        $this->info("Actualización completada.");
    }
}
