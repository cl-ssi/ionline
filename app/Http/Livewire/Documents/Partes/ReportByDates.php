<?php

namespace App\Http\Livewire\Documents\Partes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Documents\Parte;

class ReportByDates extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $start_at;
    public $end_at;

    protected $rules = [
        'start_at'  => 'required|date',
        'end_at'    => 'required|date',
    ];

    /**
    * filter
    */
    public function filter()
    {
        $this->validate();
    }

    public function render()
    {
        if($this->start_at AND $this->end_at)
        {
            $partes = Parte::with('files')
                ->whereEstablishmentId(auth()->user()->organizationalUnit->establishment->id)
                ->whereDate('entered_at','>=',$this->start_at)
                ->whereDate('entered_at','<=',$this->end_at)
                ->paginate(50);
        }
        else
        {
            $partes = Parte::where('id', '<', 0)->paginate();
        }

        return view('livewire.documents.partes.report-by-dates', [
            'partes' => $partes,
        ])->extends('layouts.bt4.app');
    }
}
