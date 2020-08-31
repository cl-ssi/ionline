<?php

namespace App\Pharmacies;

use Illuminate\Database\Eloquent\Model;

class Deliver extends Model
{
    protected $fillable = [
        'establishment_id', 'product_id', 'invoice', 'request_date', 'due_date', 'patient_rut', 
        'patient_name', 'age', 'request_type', 'quantity', 'diagnosis', 'doctor_name', 'remarks'
    ];

    protected $table = 'frm_deliveries';

    public function establishment()
    {
        return $this->belongsTo('App\Pharmacies\Establishment');
    }

    public function product()
    {
        return $this->belongsTo('App\Pharmacies\Product');
    }
}
