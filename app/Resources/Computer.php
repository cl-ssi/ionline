<?php

namespace App\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Computer extends Model
{
    //
    protected $fillable = [
        'id', 'type', 'brand', 'model', 'serial', 'hostname', 'domain', 'ip', 'mac_address', 'operating_system', 'processor', 'ram', 'hard_disk',
        'inventory_number', 'active_type', 'intesis_id', 'comment', 'status', 'office_serial', 'windows_serial', 'place_id'
    ];

    public function users() {
    	return $this->belongsToMany('\App\User','res_computer_user')->withTimestamps();
    }

    public function place() {
        return $this->belongsTo('App\Parameters\Place');
    }

    public function scopeSearch($query, $search) {
        if($search != "") {
            return $query->where('brand', 'LIKE', '%'.$search.'%')
                         ->orWhere('model', 'LIKE', '%'.$search.'%')
                         ->orWhere('ip', 'LIKE', '%'.$search.'%')
                         ->orWhere('serial', 'LIKE', '%'.$search.'%')
                         ->orWhere('inventory_number', 'LIKE', '%'.$search.'%');
        }
    }

    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'res_computers';
}
