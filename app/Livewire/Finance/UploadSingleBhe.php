<?php

namespace App\Livewire\Finance;

use App\Models\Finance\Dte;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\PdfToText\Pdf;

class UploadSingleBhe extends Component
{
    use WithFileUploads;

    public $bhe;
    public $bhe_to_text;
    public $dte;
    public $message = null;

    protected $rules = [
        'dte.tipo'              => 'required',
        'dte.tipo_documento'    => 'required',
        'dte.folio'             => 'required',
        'dte.emisor'            => 'required',
        'dte.razon_social_emisor' => 'required',
        'dte.receptor'          => 'required',
        'dte.emision'           => 'required|date',
        'dte.monto_total'       => 'required',
        'dte.uri'               => 'required',
        'dte.folio_oc'          => 'required',
        'dte.establishment_id'  => 'required',
    ];

    public function updatedBhe()
    {
        $this->validate([
            'bhe' => 'max:1024|mimes:pdf', // 1MB Max
        ]);

        $filename = time().'.pdf';

        $this->bhe->storeAs('bhe', $filename, 'local');

        $this->bhe_to_text = Pdf::getText(storage_path('app/bhe/'.$filename));

        // Divide el texto obtenido en líneas
        $lineas = explode("\n", $this->bhe_to_text);

        // Si la primera línea es "BOLETA DE HONORARIOS"
        if($lineas[0] == 'BOLETA DE HONORARIOS') {
            $tipo_documento = 'boleta_honorarios';
            $tipo = 69;

            // Expresion regular para obtener el folio
            preg_match("/N\s?°?\s?(\d+)/", $this->bhe_to_text, $matches);
            $folio = $matches[1];

            // Expresion regular para obtener la razon social del emisor
            preg_match("/\n\n(.+)\n\nN/", $this->bhe_to_text, $matches);
            $razon_social_emisor = $matches[1];

            // Expresion regular para obtener el run del emisor
            preg_match("/RUT: ([\d.]+−[K\d])/", $this->bhe_to_text, $matches);
            $emisor = runFormat($matches[1]);

            // Expresion regular para obtener la fecha de emision
            preg_match("/Fecha: (\d+ de .+ de \d+)/", $this->bhe_to_text, $matches);
            list($day, $de, $mes, $de, $year) = explode(' ', $matches[1]);
            
            // Mapeo de nombres de meses en español a inglés
            $meses = [
                'Enero'     => '01',
                'Febrero'   => '02',
                'Marzo'     => '03',
                'Abril'     => '04',
                'Mayo'      => '05',
                'Junio'     => '06',
                'Julio'     => '07',
                'Agosto'    => '08',
                'Septiembre'=> '09',
                'Octubre'   => '10',
                'Noviembre' => '11',
                'Diciembre' => '12',
            ];

            // Formato de fecha para la base de datos
            $emision = $year . '-' . $meses[$mes] . '-' . $day;

            // Expresion regular para obtener el run del receptor
            preg_match("/Rut: ([\d.]+− \d)/", $this->bhe_to_text, $matches);
            $receptor = runFormat($matches[1]);

            // Esto es para encontrar el último valor después del Total: que corresponde al total de la boleta
            // Encuentra el índice de la línea que contiene "Total:"
            $indiceTotal = 0;
            foreach ($lineas as $indice => $linea) {
                if (strpos($linea, 'Total:') !== false) {
                    $indiceTotal = $indice;
                    break;
                }
            }
            // Busca la última línea con un valor numérico después de "Total:"
            $monto_total = '';
            for ($i = $indiceTotal + 2; $i < count($lineas); $i++) {
                if (trim($lineas[$i]) && is_numeric(str_replace(['.', ','], '', trim($lineas[$i])))) {
                    $monto_total = trim($lineas[$i]);
                } else {
                    break; // Sale del ciclo si encuentra una línea no numérica
                }
            }

            // Limpia el monto total de caracteres no numéricos
            $monto_total = preg_replace('/[^0-9]/', '', $monto_total);

            // Expresion regular para obtener el código de barras
            preg_match("/\n(\w+)\nRes. Ex. N/", $this->bhe_to_text, $matches);
            $bar_code = $matches[1];

            // URL para descargar la boleta
            $uri = 'https://loa.sii.cl/cgi_IMT/TMBCOT_ConsultaBoletaPdf.cgi?origen=TERCEROS&txt_codigobarras='.$bar_code;

            // Asigna el establecimiento del usuario al establecimiento de la boleta
            $establishment_id = auth()->user()->organizationalUnit->establishment_id;

            $this->dte = Dte::firstOrNew([
                'tipo'      => $tipo,
                'folio'     => $folio,
                'emisor'    => $emisor,
            ]);

            $this->dte->tipo_documento      = $tipo_documento;
            $this->dte->razon_social_emisor = $razon_social_emisor;
            $this->dte->receptor            = $receptor;
            $this->dte->emision             = $emision;
            $this->dte->monto_total         = $monto_total;
            $this->dte->uri                 = $uri;
            $this->dte->establishment_id    = $establishment_id;        
        }
        else {
            $this->bhe_to_text = "NO ES UNA BOLETA DE HONORARIOS";
        }
    }

    public function save()
    {
        $this->validate();

        $this->dte->save();

        $this->reset();

        $this->message = 'BHE cargada correctamente.';
    }

    public function render()
    {
        return view('livewire.finance.upload-single-bhe');
    }
}
