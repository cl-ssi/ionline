<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RosterAnalisisToAdmin extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];


    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function items() {
        return $this->hasMany('App\Models\Drugs\RosterAnalisisToAdminItem');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    protected $table = 'drg_roster_analisis_to_admins';
}
