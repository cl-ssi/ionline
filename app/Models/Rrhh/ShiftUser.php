<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftUser extends Model
{
	/* TODO: Nomralizar los nombres de las funciones miFuncionPulenta */
    use HasFactory;
    protected $fillable = [ 'date_from', 'date_up', 'asigned_by', 'user_id','shift_types_id', 'organizational_units_id' , 'groupname','commentary','position'];

	protected $table = 'rrhh_shift_users';

	public function assignmentUser()
	{
    	return $this->belongsTo(\App\Models\User::class, 'asigned_by');
	}
	public function user()
	{
    	return $this->belongsTo(\App\Models\User::class, 'user_id');
	}

	public function shiftType()
	{
    	return $this->belongsTo(ShiftTypes::class, 'shift_types_id');
	}
	public function days()
	{
		return $this->hasMany(ShiftUserDay::class, 'shift_user_id');
	}
	public function esSuplencia(){
		$resp = "";
		if(isset($this->commentary) &&  $this->commentary != "" ){
				$resp = explode(":", $this->commentary);
				// $resp = "(".$resp[0].")";
				$resp = $resp[0];
		}else{
			// $resp = "("."titular".")";
			$resp = "titular";
		}

		return $resp;
	}
	public function	realposition(){
		$p=0;
		if(isset($this->position) && $this->position != ""  ){
				$p = $this->position;
		}elseif(isset($this->commentary) &&  $this->commentary != "" ){
				$p = explode(":", $this->commentary);
				$p = $p[1];
		}
		return $p;
	}
}
