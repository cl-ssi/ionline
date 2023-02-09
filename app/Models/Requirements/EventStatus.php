<?php

namespace App\Models\Requirements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventStatus extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id', 'requirement_id', 'event_id', 'user_id', 'status'
	];

	public function event() {
		return $this->belongsTo('App\Models\Requirements\Event');
	}

	public function requirement() {
		return $this->belongsTo('App\Requirement');
	}

	public function user() {
		return $this->belongsTo('\App\User');
	}

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at', 'limit_at'];

	/**
	 * The table associated with the model.
	*
	* @var string
	*/
	protected $table = 'req_events_status';
}
