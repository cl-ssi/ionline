<?php

namespace App\Models\rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShiftTypeMonths extends Model
{
    use HasFactory;
    protected $fillable = ['month' , 'user_id' , 'shift_type_id' ];
    protected $table = 'rrhh_user_shifttype_months';
    
    public function user(){
        
        return $this->belongsTo(\App\User::class, 'user_id');
    
    }
    public function shifttype(){
        
        return $this->belongsTo(\App\ShiftTypes::class, 'shift_type_id');
    
    }
}
