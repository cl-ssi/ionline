<?php

namespace App\Livewire\Rrhh\Attendance;

use Livewire\Component;
use App\Models\Rrhh\Attendance\Reason;

class ReasonMgr extends Component
{

    /** Mostrar o no el form, tanto para crear como para editar */
    public $formActive = false;

    public $reason;

    protected function rules()
    {
        return [
            'reason.name' => 'required|min:2',
            'reason.description' => 'nullable',
        ];
    }

    protected $messages = [
        'reason.name.required' => 'El nombre es requerido.',
    ];

    public function index()
    {
        $this->resetErrorBag();
        $this->formActive = false;
    }

    public function showForm(Reason $reason)
    {
        $this->reason = Reason::firstOrNew([ 'id' => $reason->id]);
        $this->formActive = true;
    }

    public function save()
    {
        $this->validate();
        $this->reason->save();
        $this->index();
    }

    public function delete(Reason $reason)
    {
        $reason->delete();
    }

    public function render()
    {
        return view('livewire.rrhh.attendance.reason-mgr', [
            'reasons' => Reason::orderBy('name')->get(),
        ]);
    }
}
