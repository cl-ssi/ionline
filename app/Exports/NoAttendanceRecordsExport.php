<?php

namespace App\Exports;

use App\Models\Rrhh\NoAttendanceRecord;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NoAttendanceRecordsExport implements FromCollection, WithHeadings
{
    protected $records;

    public function __construct(Collection $records)
    {
        $this->records = $records;
    }

    public function collection()
    {
        return $this->records->map(function ($record) {
            return [
                //'Id' => $record->id,
                'Entrada / Salida' => (string) $record->type,
                'RUN' => (string) $record->user->runNotFormat(),
                'Fecha registro' => (string) $record->date->format('ymd'),
                'Hora registro' => (string) $record->date->format('Hi'),
                'Motivo' => (string) $record->reason->name.' '.  $record->observation,
            ];
        });
    }

    public function headings(): array
    {
        return [
            //'Id',
            'Entrada / Salida',
            'RUN',
            'Fecha registro',
            'Hora Registro',
            'Motivo',
        ];
    }
}
