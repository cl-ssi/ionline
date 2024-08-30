<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;

class RejectedDte extends Component
{
    public $dteId;
    public $rejected;
    public $rechazar = [];
    public $motivo_rechazo = [];

    protected $listeners = ['refresh' => '$refresh'];

    protected $rules = [
        'rechazar'  => 'required',
        'motivo_rechazo'=>'required',
    ];

    public function rechazarDTE()
    {
        $this->validate();
        foreach ($this->rechazar as $id => $value) {
            $dte = Dte::find($id);
            $dte->update([
                'rejected' => $value,
                'reason_rejection' => $this->motivo_rechazo[$id],
                'rejected_user_id' => auth()->user()->id,
                'rejected_at' => now(),
            ]);
        }
        session()->flash('message', 'El Dte ha sido rechazado');        
    }

    public function render()
    {
        return view('livewire.finance.rejected-dte', [
            'rejected' => $this->rejected,
        ]);
    }
}
