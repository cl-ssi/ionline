<?php

namespace App\Exports;

use App\Models\Pharmacies\Dispatch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class DispatchExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Dispatch::all();
        return Dispatch::where('pharmacy_id',session('pharmacy_id'))->orderBy('id','DESC')->get();
    }

    public function headings(): array
    {
        return ['id', 'fecha', 'destino','notas','Estado recepción'];
    }

    public function map($dispatch): array
    {
        if($dispatch->verificationMailings->count()>0){
            return [
                $dispatch->id,
                Date::dateTimeToExcel($dispatch->date),
                ($dispatch->destiny ? $dispatch->destiny->name : '') . ' ' . ($dispatch->receiver ? $dispatch->receiver->shortName : ''),
                $dispatch->notes,
                $dispatch->verificationMailings->last()->status,
            ];
        }else{
            return [
                $dispatch->id,
                Date::dateTimeToExcel($dispatch->date),
                ($dispatch->destiny ? $dispatch->destiny->name : '') . ' ' . ($dispatch->receiver ? $dispatch->receiver->shortName : ''),
                $dispatch->notes,
                '',
            ];
        }
        
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_GENERAL,
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => NumberFormat::FORMAT_GENERAL,
            'D' => NumberFormat::FORMAT_GENERAL,
            'E' => NumberFormat::FORMAT_GENERAL,
        ];
    }
}
