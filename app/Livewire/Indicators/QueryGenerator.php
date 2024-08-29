<?php
namespace App\Livewire\Indicators;

use Livewire\Component;
use DateTime;
use App\Models\Indicators\Indicator;
use App\Helpers\SqlFormatter;

class QueryGenerator extends Component
{
    public $name;
    public $number;
    public $numerator;
    public $denominator;
    public $numerator_source;
    public $denominator_source;
    public $numerator_cods; // Obtener de otro archivo
    public $denominator_cods; // Obtener de otro archivo
    public $numerator_cols;
    public $denominator_cols;
    public $goal;

    public function render()
    {
        $datos = [
            'id' => null,
            'number' => $this->number,
            'name' => $this->name, // 'Porcentaje de niños y niñas de 12 a 23 meses con riesgo del desarrollo psicomotor recuperados',
            'weighting_by_section' => null,
            'evaluated_section_states' => null,
            'numerator' => $this->numerator, //'Niños 12 a 23 meses con rdsm recuperados de enero a diciembre 2023',
            'numerator_source' => $this->numerator_source, // 'REM A03, sección A.2 Celdas J25 + K25 + L25 + M25 + J27 + K27 + L27 + M27',
            'numerator_cods' => $this->numerator_cods, //'02010420,03500366',
            'numerator_cols' => $this->numerator_cols, //'Col08,Col09,Col10,Col11',
            'numerator_acum_last_year' => null,
            'denominator' => $this->denominator, // 'Niños 12 a 23 meses diagnosticados en primera evaluación con rdsm de octubre 2022 a septiembre 2023 - derivados - trasladados',
            'denominator_source' => $this->denominator_source, // 'REM A03, Sección A.2 Celdas (J22 + K22 + L22 + M22) - (J36 + K36 + L36 + M36) - (J39 - K39 - L39 - M39)',
            'denominator_cods' => $this->denominator_cods, // '02010321,-03500334,-03500331',
            'denominator_cols' => $this->denominator_cols, // 'Col08,Col09,Col10,Col11',
            'denominator_acum_last_year' => null,
            'denominator_values_by_commune' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'indicatorable_id' => 33,
            'indicatorable_type' => 'App\\\\Models\\\\Indicators\\\\HealthGoal',
            'goal' => $this->goal, //'0%,0%,0%,0%,0%,0%,0%',
            'weighting' => null,
            'precision' => null,
            'level' => null,
            'population' => null,
            'professional' => null,
            'establishment_cods' => null,
            'deleted_at' => null
        ];
        
        
        function crearConsultaSQL($tabla, $datos) {
            $columnas = implode("`, `", array_keys($datos));

            $valoresArray = array_map(function($valor) {
                if (is_null($valor)) {
                    return 'NULL';
                } else {
                    return "'".$valor."'";
                }
            }, $datos);
        
            $valores = implode(", ", $valoresArray);
        
            return "INSERT INTO $tabla (`$columnas`) VALUES ($valores)";
        }
        
        $tabla = "indicators";
        $query = crearConsultaSQL($tabla, $datos);
        $formatedQuery = SqlFormatter::format($query);
        
        // echo $query);
        // die();
        return view('livewire.indicators.query-generator', compact('query','formatedQuery'));
    }

    /**
    * Process
    */
    public function process()
    {
        $this->goal = trim($this->goal);
        $this->numerator = trim($this->numerator);
        $this->denominator = trim($this->denominator);
        $this->name = trim(ucfirst(strtolower($this->name)));
    }
}
