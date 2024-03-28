<?php

namespace App\Http\Livewire\Finance;

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

    protected $rules = [
        'dte.tipo' => 'required',
        'dte.tipo_documento' => 'required',
        'dte.folio' => 'required',
        'dte.emisor' => 'required',
        'dte.razon_social_emisor' => 'required',
        'dte.receptor' => 'required',
        'dte.emision' => 'required|date',
        'dte.monto_total' => 'required',
        'dte.uri' => 'required',
        'dte.folio_oc' => 'required',
        'dte.establishment_id' => 'required',
    ];

    public function process()
    {
        $this->validate([
            'bhe' => 'max:1024|mimes:pdf', // 1MB Max
        ]);

        $filename = time().'.pdf';
        // $filename = 'tmp.pdf';
        
        $this->bhe->storeAs('bhe', $filename, 'local');

        $this->bhe_to_text = Pdf::getText(storage_path('app/bhe/'.$filename));

        $this->dte = new Dte();

        // Divide el texto en líneas
        $lineas = explode("\n", $this->bhe_to_text);

        if($lineas[0] == 'BOLETA DE HONORARIOS') {
            $this->dte->tipo_documento = 'boleta_honorarios';
            $this->dte->tipo = 69;

            preg_match("/N ° (\d+)/", $this->bhe_to_text, $matches);
            $this->dte->folio = $matches[1];

            preg_match("/\n\n(.+)\n\nN/", $this->bhe_to_text, $matches);
            $this->dte->razon_social_emisor = $matches[1];

            preg_match("/RUT: ([\d.]+−\d)/", $this->bhe_to_text, $matches);
            $this->dte->emisor = runFormat($matches[1]);

            preg_match("/Fecha: (\d+ de .+ de \d+)/", $this->bhe_to_text, $matches);
            list($day, $de, $mes, $de, $year) = explode(' ', $matches[1]);
            
            // Mapeo de nombres de meses en español a inglés
            $meses = [
                'Enero' => '01',
                'Febrero' => '02',
                'Marzo' => '03',
                'Abril' => '04',
                'Mayo' => '05',
                'Junio' => '06',
                'Julio' => '07',
                'Agosto' => '08',
                'Septiembre' => '09',
                'Octubre' => '10',
                'Noviembre' => '11',
                'Diciembre' => '12',
            ];

            // Parsea la fecha
            $this->dte->emision = $year . '-' . $meses[$mes] . '-' . $day;

            preg_match("/Rut: ([\d.]+− \d)/", $this->bhe_to_text, $matches);
            $this->dte->receptor = runFormat($matches[1]);

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

            // preg_match("/Total:\n\n[\d.]+\n([\d.]+)/", $this->bhe_to_text, $matches);
            $this->dte->monto_total = preg_replace('/[^0-9]/', '', $monto_total);

            preg_match("/\n(\w+)\nRes. Ex. N/", $this->bhe_to_text, $matches);
            $bar_code = $matches[1];

            $this->dte->uri = 'https://loa.sii.cl/cgi_IMT/TMBCOT_ConsultaBoletaPdf.cgi?origen=TERCEROS&txt_codigobarras='.$bar_code;
            
            $this->dte->establishment_id = auth()->user()->organizationalUnit->establishment_id;
        }
        else {
            $this->bhe_to_text = "NO ES UNA BOLETA DE HONORARIOS";
        }    
    }

    public function save()
    {
        $this->dte->save();

        $this->reset();
    }

    public function render()
    {
        return view('livewire.finance.upload-single-bhe');
    }
}
