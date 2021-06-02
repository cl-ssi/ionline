<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftUserDay extends Model
{
    use HasFactory;
    protected $fillable = [ 'day' ,'commentary' ,'status','shift_user_id','working_day','derived_from' ];

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
	public function confirmationStatus(){

	}

}
