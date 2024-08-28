<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Sirh\WelfareUser;

class SyncWelfareUsersCommand extends Command
{
    protected $signature = 'sync:welfare-users';

    protected $description = 'Syncs Welfare Users with Users';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $welfareUsers = WelfareUser::all();
        $count = 0;

        foreach ($welfareUsers as $welfareUser) {
            // Verificar si el usuario ya existe en la tabla Users
            $user = User::withTrashed()->find($welfareUser->rut);
            
            // Si el usuario no existe, crear uno nuevo
            if (!$user) {

                $user = new User();
                $user->id = $welfareUser->rut;
                $user->dv = $welfareUser->dv;

                // Separar el texto por el espacio
                $partesNombre = explode(" ", $welfareUser->nombre);

                // Obtener el apellido paterno (primer elemento)
                $apellidoPaterno = $partesNombre[0];

                // Obtener el apellido materno (segundo elemento)
                $apellidoMaterno = $partesNombre[1];

                // Obtener el nombre (lo que queda)
                unset($partesNombre[0], $partesNombre[1]); // Remover los elementos de apellido paterno y materno
                $nombreCompleto = implode(" ", $partesNombre);
                
                $user->name = $nombreCompleto;
                $user->fathers_family = $apellidoPaterno;
                $user->mothers_family = $apellidoMaterno;
                $user->gender = $this->mapGender($welfareUser->sexo);
                $user->address = $welfareUser->direccion;
                $user->phone_number = $welfareUser->telefono;
                // $user->password = bcrypt($welfareUser->password); 
                $user->birthday = $welfareUser->fecha_nac;
                $user->active = 1;
                $user->establishment_id = $welfareUser->establ_id;
                $user->organizational_unit_id = $this->getOrganizationalUnitId($welfareUser->unidad);

                // Guardar el usuario
                $user->save();
                $count += 1;

                print_r($welfareUser->rut . " \n");
            }
        }

        $this->info('Usuarios de bienestar (SIRH) sincronizados correctamente en Ionline! (cantidad de registros: ' . $count . ' )' );
    }

    // Función para mapear el género de WelfareUser a User
    private function mapGender($gender)
    {
        if ($gender === 'M') {
            return 'male';
        } elseif ($gender === 'F') {
            return 'female';
        } else {
            return null;
        }
    }

    // Función para obtener el ID de la unidad organizacional
    private function getOrganizationalUnitId($unitName)
    {
        $organizationalUnit = OrganizationalUnit::where('sirh_ou_id', $unitName)->first();
        if ($organizationalUnit) {
            return $organizationalUnit->id;
        } else {
            return null;
        }
    }
}
