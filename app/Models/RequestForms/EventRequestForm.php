<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class EventRequestForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'signer_user_id', 'request_form_id', 'ou_signer_user', 'position_signer_user', 'cardinal_number', 'status', 'comment', 'signature_date'
    ];


    public function signerUser(){
        return $this->belongsTo(User::class, 'signer_user_id');
    }

    public function requestForm() {
        return $this->belongsTo(RequestForm::class, 'request_form_id');
    }

    public function

    protected $table = 'arq_event_request_forms';
}
