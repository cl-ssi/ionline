<?php

namespace App\Traits;

use App\User;
use App\Models\Documents\Numeration;
use App\Models\Parameters\Parameter;

trait NumerateTrait
{
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
            $numeration->numerator_id = auth()->id();
            $numeration->date = now();
            $numeration->save();
        } else {
            $this->error_msg = $status;
        }
    }
}