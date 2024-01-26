<?php

namespace App\Http\Livewire\Documents\Partes;

use Livewire\Component;
use App\Models\Documents\Numeration;
use App\Models\Parameters\Parameter;
use App\User;

class NumerationInbox extends Component
{
    public $error_msg;

    /**
     * Numerate
     */
    public function numerate(Numeration $numeration)
    {
        $this->error_msg = null;

        $user_id = Parameter::get('partes','numerador', auth()->user()->organizationalUnit->establishment_id);

        $user = User::find($user_id);

        $status = $numeration->numerate($user);
        if ($status === true) {
            $numeration->numerator_id = $user_id;
            $numeration->date = now();
            $numeration->save();
        } else {
            $this->error_msg = $status;
        }
    }

    public function render()
    {
        $numerations = Numeration::where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
            ->latest()
            ->get();

        return view('livewire.documents.partes.numeration-inbox', [
            'numerations' => $numerations,
        ]);
    }
}
