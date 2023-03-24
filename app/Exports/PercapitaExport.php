<?php

namespace App\Exports;

use App\Models\Indicators\Percapita;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, ShouldAutoSize};
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;

class PercapitaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $new_etario = $this->request->etario_id;
        if (in_array('>=100', $new_etario)) {
            $max_edad = Percapita::year($this->request->year)
                ->where('ACEPTADO_RECHAZADO', 'ACEPTADO')
                ->max('Edad');
            array_pop($new_etario);

            foreach (range(100, $max_edad) as $edad) {
                $new_etario[] = $edad;
            }
        }

        return Percapita::year($this->request->year)
            ->join($this->request->year . 'establecimientos', 'COD_CENTRO', '=', $this->request->year . 'establecimientos.Codigo')
            ->where('ACEPTADO_RECHAZADO', 'ACEPTADO')
            ->whereIn('COD_CENTRO', $this->request->establishment_id)
            ->whereIn('GENERO', $this->request->gender_id)
            ->when(count($this->request->etario_id) != 101, function ($query) use ($new_etario) {
                $query->whereIn('Edad', $new_etario);
            })->get();
    }


    public function headings(): array
    {
        return [
            'Centro',
            'Comuna',
            'Edad',
            'Sexo',
        ];
    }

    public function map($percapita): array
    {
        return [
            $percapita->NOMBRE_CENTRO,
            $percapita->comuna,
            $percapita->EDAD,
            $percapita->GENERO,
        ];
    }
}
