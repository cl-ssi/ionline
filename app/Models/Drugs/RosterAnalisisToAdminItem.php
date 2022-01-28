<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RosterAnalisisToAdminItem extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'roster_id','reception_id'
    ];

    public function roster() {
        return $this->belongsTo('App\Models\Drugs\RosterAnalisisToAdmin', 'roster_id', 'drg_roster_analisis_to_admins');
    }

    public function receptions() {
        return $this->hasMany('App\Models\Drugs\Reception', 'reception_id', 'drg_receptions');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'drg_roster_analisis_to_admin_items';
}
