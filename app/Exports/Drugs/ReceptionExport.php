<?php

namespace App\Exports\Drugs;

use App\Models\Drugs\ReceptionItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ReceptionExport implements FromCollection, WithMapping, WithHeadings
{
    public $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ReceptionItem::query()
            ->with(
                [
                    'reception',
                    'reception.user',
                    'reception.partePoliceUnit',
                    'reception.court',
                    'resultSubstance',
                    'reception.destruction',
                    'reception.sampleToIsp',
                    'reception.recordToCourt',
                    'substance',
                    'actPrecursorItem',
                    'actPrecursorItem.act_precursor',
                ]
            )
            ->whereBetween('created_at', [
                $this->year . '-01-01 00:00:00',
                $this->year . '-12-31 23:59:59'
            ])
            ->get();
    }

    /**
     * @param ReceptionItem $item
     */
    public function map($item): array
    {
        return [
            $item->id,
            $item->reception->user->initials,
            $item->reception->id,
            $item->reception->date->format('d-m-Y'),
            $item->reception->document_number,
            $item->reception->partePoliceUnit?->name,
            $item->reception->delivery,
            $item->reception->parte,
            $item->reception->court->name,
            $item->nue,
            $item->substance->name,
            $item->resultSubstance?->name,
            implode(', ', $item->protocols->pluck('result')->unique()->toArray()),
            $item->document_weight,
            $item->gross_weight,
            $item->net_weight,
            $item->sample_number,
            $item->sample,
            $item->countersample_number,
            $item->countersample,
            $item->reception->destruction?->user?->initials,
            $item->reception->wasDestructed() ? '' : $item->destruct,
            $item->reception->destruction?->destructed_at->format('d-m-Y'),
            $item->reception->wasDestructed() ? $item->destruct : '',
            $item->reception->sampleToIsp?->number,
            $item->reception->recordToCourt?->number,
            $item->actPrecursorItem?->act_precursor->id,
            $item->actPrecursorItem?->act_precursor->date->format('d-m-Y'),
            $item->actPrecursorItem?->act_precursor->full_name_receiving,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Autor',
            'N° Rec',
            'Fecha',
            'Oficio',
            'Policia',
            'Funcionario que entrega',
            'Parte',
            'Fiscalia',
            'NUE',
            'Sustancia Presunta',
            'Sustancia Determinda ISP',
            'Protocolo Análisis SS',
            'P.Oficio',
            'P.Bruto',
            'P.Neto',
            'Cant.Muestra',
            'Peso.Muestra',
            'Cant.CMuestra',
            'Peso.CMuestra',
            'Autor',
            'Por Destruir',
            'Fecha dest.',
            'Destruido',
            'N°Envío a ISP',
            'N°Envío a Fiscalía',
            'Acta precursor enajenado',
            'Fecha acta enajenación',
            'Receptor',
        ];
    }
}
