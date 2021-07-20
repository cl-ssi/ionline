<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequestOfDay extends Model
{
    use HasFactory;
    protected $table = 'rrhh_user_request_of_days';
    protected $fillable = [ 'status','commentary','shift_user_day_id','user_id','status_change_by'];
    /* Status, Pendiente, Cancelada, Aceptada, Rechazada */
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
    public function ChangeBy()
    {
        return $this->belongsTo(\App\User::class, 'status_change_by');
    }
    public function ShiftUserDay()
    {
        return $this->belongsTo(ShiftUserDay::class, 'shift_user_day_id');
    }
    public function statusColor(){
        if($this->status == "pendiente")
            return "orange";
        elseif($this->status == "cancelado")
            return "red";
        elseif($this->status == "rechazado")
            return "red";
        elseif($this->status == "confirmado")
            return "green";
        else
            return "gray";
    }
}
