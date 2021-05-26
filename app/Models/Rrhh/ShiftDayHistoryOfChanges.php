<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftDayHistoryOfChanges extends Model
{
    use HasFactory;

    protected $fillable = [ 'previous_user','current_user','previous_value','current_value','day','modified_by','change_type','commentary','shift_user_day_id'];
    protected $table = 'rrhh_shift_day_hitory_of_changes';
	/*1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario, 4 cambio confirmado por usuario, 5 cambio confirmado por administrador*/
    public function ShiftUserDay()
	{
    	return $this->belongsTo(ShiftUserDay::class, 'shift_user_day_id');
	}
	public function PreviousUser()
	{
    	return $this->belongsTo(User::class, 'previous_user');
	}
	public function CurrentUser()
	{
    	return $this->belongsTo(User::class, 'current_user');
	}
	public function ModifiedBy()
	{
    	return $this->belongsTo(User::class, 'modified_by');
	}
}
