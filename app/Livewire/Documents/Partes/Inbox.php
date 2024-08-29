<?php

namespace App\Livewire\Documents\Partes;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Documents\Type;
use App\Models\Documents\Parte;

class Inbox extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $types;

    public $parte_correlative;
    public $parte_type_id;
    public $parte_number;
    public $parte_origin;
    public $parte_subject;
    public $parte_without_sgr;
    public $parte_important;

    /**
    * Mount
    */
    public function mount()
    {
        $this->types = Type::pluck('name','id');

        
        $this->parte_correlative = session('parte_correlative');
        $this->parte_type_id = session('parte_type_id');
        $this->parte_number = session('parte_number');
        $this->parte_origin = session('parte_origin');
        $this->parte_subject = session('parte_subject');
        $this->parte_without_sgr = session('parte_without_sgr');
        $this->parte_important = session('parte_important');
    }

    public function search() 
    {        
        session(['parte_correlative' => $this->parte_correlative]);
        session(['parte_type_id' => $this->parte_type_id]);
        session(['parte_number' => $this->parte_number]);
        session(['parte_origin' => $this->parte_origin]);
        session(['parte_subject' => $this->parte_subject]);
        session(['parte_without_sgr' => $this->parte_without_sgr]);
        session(['parte_important' => $this->parte_important]);
        $this->resetPage();
    }

    public function removeFilter($filter)
    {
        session()->forget($filter);
        $this->$filter = null;
    }

    public function render()
    {
        $partes = Parte::query()
            ->whereEstablishmentId(auth()->user()->organizationalUnit->establishment->id)
            ->filter('correlative', $this->parte_correlative)
            ->filter('type_id', $this->parte_type_id)
            ->filter('number', $this->parte_number)
            ->filter('origin', $this->parte_origin)
            ->filter('subject', $this->parte_subject)
            ->filter('without_sgr', $this->parte_without_sgr)
            ->filter('important', $this->parte_important)
            ->with([
                'type',
                'requirements',
                'files',
                'requirements.events',
                'requirements.events.to_user',
                // 'files.signatureFile.signaturesFlows',
                // 'files.signatureFile',
                ])
            ->latest()->paginate('100');

        /** Log access a partes, no crea otro registro, si el usuario ingreso dentro de los últimos x minutos */
        $minutos = 15;
        $ha_ingresado_en_rango_de_x_minutos = auth()->user()->accessLogs->where('type','partes')->where('created_at', '>', now()->subMinutes($minutos))->last();
        
        if(!$ha_ingresado_en_rango_de_x_minutos) {
            // Registramos su acceso a partes
            auth()->user()->accessLogs()->create([
                'type' => 'partes',
                'switch_id' => session()->get('god'),
                'enviroment' => 'Cloud Run' // Ya no es necesario
            ]);
        }

        return view('livewire.documents.partes.inbox', ['partes' => $partes])->extends('layouts.bt4.app');
    }
}
