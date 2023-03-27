<?php

namespace App\Models\Indicators;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'ind_sections';
    protected $fillable = ['number', 'weighting'];

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class)->orderBy('number');
    }
}
