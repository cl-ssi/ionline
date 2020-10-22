<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    public function agreements() {
        return $this->hasMany('App\Agreement\Agreement');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function establishments() {
    		return $this->hasMany('\App\Establishment');
    }

    public function municipality() {
            return $this->hasOne('\App\Municipality');
    }

}
