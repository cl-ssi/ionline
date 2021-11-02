<?php

namespace App\Programmings;

use Illuminate\Database\Eloquent\Model;

class ProfessionalHour extends Model
{
    protected $table = 'pro_professional_hours';

    protected $fillable = [
        'professional_id', 'programming_id', 'value'
    ];

    public function professional(){
        return $this->belongsTo('App\Programmings\Professional');
    }

    public function programming(){
        return $this->belongsTo('App\Programmings\Programming');
    }
}
