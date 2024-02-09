<?php

namespace App\Traits;

use App\User;
use App\Models\Documents\Numeration;
use App\Models\Parameters\Parameter;
use Illuminate\Support\Facades\Mail;
use App\Notifications\Finance\NewReceptionSigned;

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

        
        // if($numeration->numerable_type == 'App\Models\Finance\Receptions\Reception') {
        //     $emails = Parameter::get('Receptions','emails_notification', $numeration->establishment_id);
        //     /**
        //      * Envia la notificacion por email
        //      */
        //     if($emails) {
        //         Notification::route('mail', $emails)->notify(new NewReceptionSigned($this));
        //     }
        // }
    }
}