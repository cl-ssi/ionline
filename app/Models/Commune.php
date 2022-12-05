<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
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
    
    public function agreements() {
        return $this->hasMany('App\Agreement\Agreement');
    }
    
    public function establishments() {
        return $this->hasMany('\App\Models\Establishment');
    }

    public function municipality() {
        return $this->hasOne('\App\Models\Parameters\Municipality');
    }

    public function communeFiles() {
        //return $this->hasOne('\App\Programmings\CommuneFile'); Original
        return $this->hasMany('\App\Models\Programmings\CommuneFile');//Modificado por ozc
    }

}
