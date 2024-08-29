<?php

namespace App\Livewire\Documents\Tic;

use Livewire\Component;
use Carbon\Carbon;

class Informe extends Component
{
    public $period;
    public $github_input = null;
    public $headers = [];
    public $issues = [];
    public $filtered_issues = [];
    public $records = null;

    /**
    * mount
    */
    public function mount()
    {
        $this->period = now()->format('Y-m');
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

        $this->records = count($this->issues);
    }

    public function render()
    {
        $this->filtered_issues = [];

        foreach($this->issues as $key => $issue) {
            $this->filtered_issues[$key] = $issue;
            // Convertir las fechas a objetos Carbon
            $this->filtered_issues[$key]['Start at'] = Carbon::parse($issue['Start at']);
            $this->filtered_issues[$key]['End at'] = Carbon::parse($issue['End at']);
        }

        // Filtrar los issues por el periodo seleccionado
        $this->filtered_issues = array_filter($this->filtered_issues, function($issue) {
            return $issue['Start at']->format('Y-m') == $this->period;
        });

        // Ordenar los issues por fecha de inicio
        usort($this->filtered_issues, function($a, $b) {
            return $a['Start at'] <=> $b['Start at'];
        });

        return view('livewire.documents.tic.informe');
    }
}
