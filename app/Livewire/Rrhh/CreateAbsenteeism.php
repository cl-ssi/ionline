<?php

namespace App\Livewire\Rrhh;

use App\Models\Rrhh\Absenteeism;
use App\Models\Rrhh\AbsenteeismType;
use Livewire\Component;

class CreateAbsenteeism extends Component
{
    public $finicio;
    public $ftermino;
    public $absenteeism_type_id;
    public $jornada;
    public $observacion;


    protected $rules = [
        'finicio'             => 'required|date',
        'ftermino'            => 'required|date|after_or_equal:finicio',
        'absenteeism_type_id' => 'required|numeric',
        'jornada'             => 'nullable',
        'observacion'         => 'nullable',
    ];

    public function save()
    {
        $this->validate();

        $absenteeism = Absenteeism::create([
            'finicio'                   => $this->finicio,
            'ftermino'                  => $this->ftermino,
            'absenteeism_type_id'       => $this->absenteeism_type_id,
            'jornada'                   => $this->jornada,
            'observacion'               => $this->observacion,
            // Otros valores seteados por defecto
            'rut'                       => auth()->id(),
            'dv'                        => auth()->user()->dv,
            'nombre'                    => auth()->user()->fullName,
            'tipo_de_ausentismo'        => AbsenteeismType::find($this->absenteeism_type_id)->name,
            'codigo_de_establecimiento' => auth()->user()->establishment?->sirh_code,
            'nombre_de_establecimiento' => auth()->user()->establishment?->name,
            'codigo_unidad'             => auth()->user()->organizationalUnit?->sirh_ou_id,
            'nombre_unidad'             => auth()->user()->organizationalUnit?->name,
            'edadanos'                  => auth()->user()->age,
            'edadmeses'                 => auth()->user()->ageMonths,
        ]);

        $absenteeism->createApproval();

        session()->flash('message', 'Ausentismo creado exitosamente.');

        return redirect()->route('rrhh.absenteeisms.index');
    }

    public function render()
    {
        $absenteeismTypes = AbsenteeismType::where('name', 'not like', 'L.M.%')
            ->orderBy('name')
            ->pluck('name', 'id');
        return view('livewire.rrhh.create-absenteeism', compact('absenteeismTypes'));
    }
}
