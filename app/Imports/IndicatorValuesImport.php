<?php

namespace App\Imports;

use App\Indicators\Value;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class IndicatorValuesImport implements ToCollection
{
    private $valueable_id;
    private $commune;

    public function __construct($valueable_id, $commune)
    {
        $this->valueable_id = $valueable_id;
        $this->commune = $commune;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '0.0' => ['required','in:ACTIVIDADES'],
            '0.1' => ['required','in:FRECUENCIA'],
            '1.1' => ['required','in:ENE'],
            '1.2' => ['required','in:FEB'],
            '1.3' => ['required','in:MAR'],
            '1.4' => ['required','in:ABR'],
            '1.5' => ['required','in:MAY'],
            '1.6' => ['required','in:JUN'],
            '1.7' => ['required','in:JUL'],
            '1.8' => ['required','in:AGO'],
            '1.9' => ['required','in:SEP'],
            '1.10' => ['required','in:OCT'],
            '1.11' => ['required','in:NOV'],
            '1.12' => ['required','in:DIC'],
        ])->validate();

        foreach($rows as $key => $row){
            if(!in_array($key, [0,1])){
                for($i = 1; $i <= 12; $i++){ //de 1 (enero) a 12 (diciembre)
                    if(mb_strtoupper($row[$i]) == 'X'){
                        Value::create([
                            'activity_name' => $row[0],
                            'month' => $i,
                            'factor' => 'denominador',
                            'commune' => $this->commune,
                            'value' => 1,
                            'valueable_id' => $this->valueable_id,
                            'valueable_type' => 'App\Indicators\Indicator',
                            'created_by' => Auth::id(),
                            'updated_by' => Auth::id(),
                        ]);
                    }
                }
            }
        }
    }
}
