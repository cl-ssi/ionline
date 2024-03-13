<?php

namespace App\Exports;

use App\Models\Parameters\Place;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlacesExport implements FromCollection, WithHeadings
{
    protected $places;

    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function __construct($places)
    {
        $this->places = $places;
    }


    public function collection()
    {
        $data = $this->places->map(function ($place) {
            return [
                'ID' => $place->id,
                'Nombre' => $place->name,
                'Descripción' => $place->description,
                'Ubicación' => $place->location->name,
                'Código interno Arquitectura' => $place->architectural_design_code,
                'Establecimiento' => $place->establishment->name,
            ];
        });

        return $data;
    }


    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Descripción',
            'Ubicación',
            'Código interno Arquitectura',
            'Establecimiento',
        ];
    }

    
}
