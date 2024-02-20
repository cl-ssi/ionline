<?php

namespace App\Exports\Agreements;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;
use Livewire\Component;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class TrackingAgreementsExport implements FromView, ShouldAutoSize //FromCollection, WithMapping, ShouldAutoSize, WithHeadings
{
    // use Exportable;
    public $resultSearch;
    public $period;

    public function __construct(Collection $resultSearch, $period)
    {
        // dd($resultSearch);
        $this->resultSearch = $resultSearch;
        $this->period = $period;
    }

    public function view(): View
    {
        return view('agreements.exports.tracking_agreements', [
            'agreements' => $this->resultSearch,
            'period' => $this->period
        ]);
    }

    // public function collection()
    // {
    //     return $this->resultSearch;
    // }

    // public function headings(): array
    // {
    //     return [
    //       '#',
    //       'Nombre',
    //       'Comuna',
    //       'RTP',
    //       'DAP',
    //       'DAJ',
    //       'DGF',
    //       'SDGA',
    //       'Comuna',
    //       'Director/a',
    //       'Res. N°',
    //       'Monto total'
    //     ];
    // }

    // public function map($agreement): array
    // {
    //     $components = [];
    //     $montoTotal = 0;
    //     foreach($agreement->agreement_amounts as $amount){
    //         $montoTotal += $amount->amount;
    //         if($amount->amount != 0)
    //             $components[] = $amount->program_component->name;
    //     }

    //     return [
    //         $agreement->id,
    //         $agreement->program->name.($components ? ' ('.implode(', ', $components).')' : '') ?? 'Retiro voluntario',
    //         $agreement->commune->name,
    //         $agreement->file_to_endorse_id ? $agreement->getEndorseObservationBySignPos(1) : ($agreement->stages->where('type', 'RTP')->where('group', 'CON')->first()->dateEndText ?? 'En espera'),
    //         $agreement->file_to_endorse_id ? $agreement->getEndorseObservationBySignPos(2) : ($agreement->stages->where('type', 'DAP')->where('group', 'CON')->first()->dateEndText ?? 'En espera'),
    //         $agreement->file_to_endorse_id ? $agreement->getEndorseObservationBySignPos(3) : ($agreement->stages->where('type', 'DAJ')->where('group', 'CON')->first()->dateEndText ?? 'En espera'),
    //         $agreement->file_to_endorse_id ? $agreement->getEndorseObservationBySignPos(4) : ($agreement->stages->where('type', 'DGF')->where('group', 'CON')->first()->dateEndText ?? 'En espera'),
    //         $agreement->file_to_endorse_id ? $agreement->getEndorseObservationBySignPos(5) : ($agreement->stages->where('type', 'SDGA')->where('group', 'CON')->first()->dateEndText ?? 'En espera'),
    //         $agreement->stages->where('type', 'Comuna')->where('group', 'CON')->first()->dateEndText ?? 'En espera',
    //         $agreement->file_to_sign_id ? $agreement->getSignObservation() : ($agreement->stages->where('type', 'Director')->where('group', 'CON')->first()->dateEndText ?? 'En espera'),
    //         $agreement->res_exempt_number,
    //         $montoTotal > 0  ? $montoTotal : $agreement->total_amount
    //     ];
    // }
}
