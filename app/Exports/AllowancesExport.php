<?php

namespace App\Exports;

use App\Models\Allowances\Allowance;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting};
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AllowancesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting
{
    use Exportable;

    protected $from;
    protected $to;
    
    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function collection()
    {
        return Allowance::latest()
            ->whereBetween('from', [$this->from, $this->to." 23:59:59"])
            ->get();
    }

    public function headings(): array
    {
        return [
            'N°',
            'Estado',
            'Mes (Creación)',
            'Fecha (Creación)',
            'Nombre',
            'Unidad organizacional',
            'Establecimiento',
            'Desde',
            'Hasta',
            'Cantidad de días',
            'Valor día',
            'Valor medio día',
            'Valor total',
            'Lugar',
            'Motivo'
        ];
    }

    public function map($allowance): array
    {
        return [
            ($allowance->correlative) ? $allowance->correlative : $allowance->id,
            $allowance->StatusValue,
            $allowance->created_at->monthName,
            $allowance->created_at->format('d-m-Y'),
            $allowance->userAllowance->fullName,
            $allowance->organizationalUnitAllowance->name,
            $allowance->organizationalUnitAllowance->establishment->name,
            $allowance->from->format('d-m-Y'),
            $allowance->to->format('d-m-Y'),
            $allowance->total_days,
            ($allowance->total_days >= 1) ? ($allowance->day_value * intval($allowance->total_days)) : '',
            $allowance->half_day_value,
            $allowance->total_value,
            $allowance->place,
            $allowance->reason
        ];
    }

    public function columnFormats(): array
    {
        return [
            'I' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_NUMBER,
            'K' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
