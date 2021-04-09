<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftTypes extends Model
{
    use HasFactory;
    protected $fillable = [ 'name', 'shortname', 'day_series', 'status'];
	protected $table = 'rrhh_shift_types';

	public function users()
	{
    	return $this->hasMany(ShiftUser::class, 'shift_types_id');
	}
}
