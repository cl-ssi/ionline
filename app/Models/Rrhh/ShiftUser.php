<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftUser extends Model
{
    use HasFactory;
    protected $fillable = [ 'date_from', 'date_up', 'asigned_by', 'user_id','shift_types_id', 'organizational_units_id' ];

	protected $table = 'rrhh_shift_users';

	public function assignmentUser()
	{
    	return $this->belongsTo(\App\User::class, 'asigned_by');
	}
	public function user()
	{
    	return $this->belongsTo(\App\User::class, 'user_id');
	}

	public function shiftType()
	{
    	return $this->belongsTo(ShiftTypes::class, 'shift_types_id');
	}
	public function days()
	{
		return $this->hasMany(ShiftUserDay::class, 'shift_user_id');
	}
}
