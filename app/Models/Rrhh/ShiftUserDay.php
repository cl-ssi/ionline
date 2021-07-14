<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Rrhh\ShiftDayHistoryOfChanges;   

class ShiftUserDay extends Model
{
    use HasFactory;
    protected $fillable = [ 'day' ,'commentary' ,'status','shift_user_id','working_day','derived_from','shift_close_id' ];

	protected $table = 'rrhh_shift_user_days';
	
	public function ShiftUser()
	{
    	return $this->belongsTo(ShiftUser::class, 'shift_user_id');
	}
	public function DerivatedShift(){

		return $this->belongsTo(ShiftUserDay::class,'derived_from');
	}
	public function shiftUserDayLog()
	{
    	return $this->hasMany(ShiftDayHistoryOfChanges::class, 'shift_user_day_id');
	}
	public function confirmationStatus(){ // estado de la confirmacion x parte del usuario administrador de la Unidad Organizacional, en este caso por requerimiento se confirmar automaticamente los dias de cada turno

		$actuallyStatus = 0;
		$reject = 0;
		if($this->status!=3)
			$actuallyStatus = 1;
		else
		{
			foreach ($this->shiftUserDayLog as $history) {
                   if($history->change_type == 4 || $history->change_type == 5 ) // 4 confirmado por usuario -  confirmado por administrador 
                        $actuallyStatus= 1;
                    elseif($history->change_type == 6) // rechazado
						$reject = 1;

                }
		}
		if($reject == 0)
			return $actuallyStatus;
		else
			return 3;
			
	}

	public function ChangedWith(){
    	return $this->hasOne(ShiftUserDay::class, 'derived_from');

	}
	public function closeStatus(){
		return $this->belongsTo(ShiftClose::class,'shift_close_id');
	}

	public function Solicitudes(){
		return $this->hasMany(UserRequestOfDay::class,'shift_user_day_id');
	}

}
