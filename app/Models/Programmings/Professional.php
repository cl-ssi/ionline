<?php

namespace App\Models\Programmings;

use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    protected $table = 'pro_professionals';
    protected $fillable = [
        'id', 'name', 'alias', 'code'
    ];

    public function professional_hours(){
        return $this->hasMany('App\Models\Programmings\ProfessionalHour');
    }

}
