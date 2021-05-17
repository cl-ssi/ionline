<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class EventRequestForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'signer_user_id', 'request_form_id', 'ou_signer_user', 'position_signer_user', 'cardinal_number', 'status',
        'comment', 'signature_date', 'event_type',
    ];


    public function signerUser(){
        return $this->belongsTo(User::class, 'signer_user_id');
    }

    public function requestForm() {
        return $this->belongsTo(RequestForm::class, 'request_form_id');
    }

    public static function createLeadershipEvent($requestForm){
        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   $requestForm->applicant->organizationalUnit->id;
        $event->cardinal_number     =   '10';
        $event->status              =   'created';
        $event->event_type           =   'leader_ship_event';
        $event->requestForm()->associate($requestForm);
        $event->save();
    }

    public static function createFinanceEvent($requestForm){

    }

    public static function createSupplyEvent($requestForm){

    }

    protected $table = 'arq_event_request_forms';
}
