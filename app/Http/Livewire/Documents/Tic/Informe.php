<?php

namespace App\Http\Livewire\Documents\Tic;

use Livewire\Component;
use Carbon\Carbon;

class Informe extends Component
{
    public $period;
    public $github_input = null;
    public $headers = [];
    public $issues = [];

    /**
    * mount
    */
    public function mount()
    {
        // $this->period = now()->format('Y-m');
        // $this->period = '2023-12';
    }

    /**
    * process
    */
    public function process()
    {
        $this->issues = [];
        $this->headers = [];

        $lineas = explode("\n",$this->github_input);
        foreach($lineas as $ct => $linea) {
            $campos = explode("\t", $linea);
            $this->issues[$ct] = $campos;
        }
        $this->headers = array_shift($this->issues);

        // Usar el array headers como keys de cada uno de los items del array issues
        foreach($this->issues as $key => $issue) {
            $this->issues[$key] = array_combine($this->headers, $issue);
        }

        // Filtrar los issues que no tengan fecha de inicio
        $this->issues = array_filter($this->issues, function($issue) {
            return $issue['Start at'] != '';
        });

        // dd($this->issues);
        foreach($this->issues as $key => $issue) {
            // Eliminar de los issues de la clave "Repository" todo lo que esté antes del "/"
            if($issue['Repository']) {
                $this->issues[$key]['Repository'] = explode('/', $issue['Repository'])[1];
            }
            // Dejar de los issues de la clave "URL" el último numero despules del "/"
            if($issue['URL']) {
                $this->issues[$key]['URL'] = explode('/', $issue['URL'])[6];
            }
        }

        // Convertir las fechas a objetos Carbon
        foreach($this->issues as $key => $issue) {
            $this->issues[$key]['Start at'] = Carbon::parse($issue['Start at']);
            $this->issues[$key]['End at'] = Carbon::parse($issue['End at']);
        }

        // Ordenar los issues por fecha de inicio
        usort($this->issues, function($a, $b) {
            return $a['Start at'] <=> $b['Start at'];
        });

    }

    public function render()
    {
        if($this->issues) {
            // dd($this->issues);
                    // Convertir las fechas a objetos Carbon
        foreach($this->issues as $key => $issue) {
            $this->issues[$key]['Start at'] = Carbon::parse($issue['Start at']);
            $this->issues[$key]['End at'] = Carbon::parse($issue['End at']);
        }
            // Filtrar los issues por el periodo seleccionado
            $this->issues = array_filter($this->issues, function($issue) {
                return $issue['Start at']->format('Y-m') == $this->period;
            });
        }

        return view('livewire.documents.tic.informe');
    }
}
