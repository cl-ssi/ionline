<?php

namespace App\Exports;

use App\Models\Resources\Computer;
use App\Models\Parameters\Place;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, ShouldAutoSize};

class ComputersExport implements FromCollection,WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Computer::select(
        //     'id', 'type', 'model', 'serial', 'hostname', 'domain', 'ip', 'mac_address', 'ip_group', 'rack', 'vlan',
        //     'network_segment', 'operating_system', 'ram', 'hard_disk', 'inventory_number', 'intesis_id','comment', 
        //     'active_type', 'status', 'office_serial', 'windows_serial'
        // )
        // ->get();

        return Computer::all();
    }

    public function headings(): array
    {
        return [
            "ID", "Tipo", "Modelo", "Serial", "Hostname", "Dominio", "IP", "Dirección MAC", "Grupo IP", "Rack", "VLAN",
            "Segmento de Red", "Sistema Operativo", "RAM", "Disco Duro", "Número de Inventario", "ID Intesis", "Comentario",
            "Tipo de Activo", "Estado", "Licencia Office", "Licencia Windows", "Usuarios Asignados", "Lugar"
        ];
    }

    public function map($computer): array{
        $assigned_users[] = null;
        if($computer->users){
            foreach($computer->users as $key => $user){
				$assigned_users[$key] = $user->fullName;
            }
            $assigned_user = implode(",", $assigned_users);
        }
        return [
            $computer->id,
            $computer->tipo(),
            $computer->model,
            $computer->serial,
            $computer->hostname,
            $computer->domain,
            $computer->ip,
            $computer->mac_address,
            $computer->ip_group,
            $computer->rack,
            $computer->vlan,
            $computer->network_segment,
            $computer->operating_system,
            $computer->ram,
            $computer->hard_disk,
            $computer->inventory_number,
            $computer->intesis_id,
            $computer->comment,
            $computer->tipoActivo(),
            $computer->status,
            $computer->office_serial,
            $computer->windows_serial,
            $assigned_user,
            ($computer->place) ? $computer->place->name : ''
        ];
    }
}
