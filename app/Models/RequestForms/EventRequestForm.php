<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequestForms\RequestForm;
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

    public static function createLeadershipEvent(RequestForm $requestForm){
        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   $requestForm->request_user_ou_id;
        $event->cardinal_number     =   1;
        $event->status              =   'pending';
        $event->event_type          =   'leader_ship_event';
        $event->requestForm()->associate($requestForm);
        $event->save();

        if($requestForm->superior_chief == 1){
            $event                      =   new EventRequestForm();
            $event->ou_signer_user      =   $requestForm->organizationalUnit->father->id;
            $event->cardinal_number     =   2;
            $event->status              =   'pending';
            $event->event_type          =   'superior_leader_ship_event';
            $event->requestForm()->associate($requestForm);
            $event->save();
        }

        return true;
    }

    public static function createPreFinanceEvent(RequestForm $requestForm){
        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   40;
        $event->cardinal_number     =   $requestForm->superior_chief == 1 ? 3 : 2;
        $event->status              =   'pending';
        $event->event_type          =   'pre_finance_event';
        $event->requestForm()->associate($requestForm);
        $event->save();
        return true;
    }

    public static function createFinanceEvent(RequestForm $requestForm){
        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   40;
        $event->cardinal_number     =   $requestForm->superior_chief == 1 ? 4 : 3;
        $event->status              =   'pending';
        $event->event_type          =   'finance_event';
        $event->requestForm()->associate($requestForm);
        $event->save();
        return true;
    }

    public static function createSupplyEvent(RequestForm $requestForm){
        $event                      =   new EventRequestForm();
        $event->ou_signer_user      =   37;
        $event->cardinal_number     =   $requestForm->superior_chief == 1 ? 5 : 4;
        $event->status              =   'pending';
        $event->event_type          =   'supply_event';
        $event->requestForm()->associate($requestForm);
        $event->save();
        return true;
    }

    protected $dates = [
        'signature_date',
    ];


    protected $table = 'arq_event_request_forms';
}
