<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftUserDay extends Model
{
    use HasFactory;
    protected $fillable = [ 'day' ,'commentary' ,'status','shift_user_id' ];

	protected $table = 'rrhh_shift_user_days';
	
	public function ShiftUser()
	{
    	return $this->belongsTo(ShiftUser::class, 'shift_user_id');
	}


}
