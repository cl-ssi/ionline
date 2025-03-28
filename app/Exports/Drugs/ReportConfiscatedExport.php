<?php

namespace App\Exports\Drugs;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ReportConfiscatedExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected Collection $data
    ) {}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Nombre de Sustancia',
            'Total de Items',
            'Cantidad de Actas',
            'Recibidos',
            'Sin Sustancia Resultante',
            'Actas sin Sustancia Resultante',
            'Peso Neto sin Sustancia Resultante',
            'Peso Neto con Sustancia Resultante',
            'Total de Contramuestras',
            'Cantidad por Destruir',
            'Cantidad Destruida',
            'Sustancias Resultantes (Destruidas)',
        ];
    }
}
