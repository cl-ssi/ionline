<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Model;

class Comges extends Model
{
    protected $table = 'ind_comges';
    protected $fillable = ['number', 'name', 'year'];

    public function users()
    {
        return $this->belongsToMany('App\User', 'ind_comges_users')
                    ->withPivot('referrer_number')
                    ->withTimestamps()
                    ->orderBy('referrer_number');
    }

    public function indicators()
    {
        return $this->hasMany('App\Indicators\Indicator')->orderBy('number');
    }

    public function sections()
    {
        return $this->hasManyThrough('App\Indicators\Section', 'App\Indicators\Indicator');
    }

    public function getReferrer($number)
    {
        return $this->users()->wherePivot('referrer_number', $number)->first();
    }
}
