<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DispatchVerificationMailing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','dispatch_id','status','sender_observation','delivery_date','receiver_observation','confirmation_date'
    ];

    use SoftDeletes;

    protected $table = 'frm_dispatch_verification_mailings';

    //relaciones
    public function dispatch()
    {
      return $this->belongsTo('App\Models\Pharmacies\Dispatch');
    }

    protected $dates = ['delivery_date','confirmation_date'];

}
