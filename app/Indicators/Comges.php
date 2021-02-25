<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        return $this->morphMany('App\Indicators\Indicator', 'indicatorable')->orderBy('number');
    }

    public function sections()
    {
        return $this->hasManyThrough('App\Indicators\Section', 'App\Indicators\Indicator', 'indicatorable_id')->where('indicatorable_type', array_search(static::class, Relation::morphMap()) ?: static::class);
    }

    public function getReferrer($number)
    {
        return $this->users()->wherePivot('referrer_number', $number)->first();
    }
}
