<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'ind_sections';
    protected $fillable = ['number', 'weighting'];

    public function indicator()
    {
        return $this->belongsTo('App\Indicators\Indicator');
    }

    public function actions()
    {
        return $this->hasMany('App\Indicators\Action')->orderBy('number');
    }
}
