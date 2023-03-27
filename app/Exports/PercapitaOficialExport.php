<?php

namespace App\Exports;

use App\Models\Indicators\PercapitaOficial;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison};
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;

class PercapitaOficialExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{
    use Exportable;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $sexo = [];
        foreach ($this->request->gender_id as $key => $gender) {
            switch ($gender) {
                case 'M':
                    $sexo[] = "Hombres";
                    break;
                case 'F':
                    $sexo[] = "Mujeres";
                    break;
                case 'I':
                    $sexo[] = "Sin. Info.";
                    break;
            }
        }

        $new_etario = $this->request->etario_id;

        if (in_array('>=100', $new_etario)) {
            $max_edad = PercapitaOficial::year($this->request->year)
                ->max('Edad');
            array_pop($new_etario);

            foreach (range(100, $max_edad) as $edad) {
                $new_etario[] = $edad;
            }
        }

        return PercapitaOficial::year($this->request->year)
            ->whereIn('Id_Centro_APS', $this->request->establishment_id)
            ->whereIn('Sexo', $sexo)
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
            'Inscritos'
        ];
    }

    public function map($percapita): array
    {
        return [
            $percapita->Centro_APS,
            $percapita->Comuna,
            $percapita->Edad == 9999 ? "111 o más" : $percapita->Edad, // Edad: 9999 => adultos mayores de 111 o + años
            $percapita->Sexo,
            $percapita->Inscritos,
        ];
    }
}
