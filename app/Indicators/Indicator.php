<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Indicator extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['number', 'name', 'weighting_by_section', 'evaluated_section_states', 'numerator',  
                           'numerator_source', 'denominator', 'denominator_source', 'numerator_acum_last_year',
                           'numerator_cods', 'numerator_cols', 'denominator_cods', 'denominator_acum_last_year',
                           'denominator_cols', 'goal', 'weighting', 'precision', 'establishment_cods'];

    public function indicatorable()
    {
        return $this->morphTo();
    }

    public function sections()
    {
        return $this->hasMany('App\Indicators\Section')->orderBy('number');
    }

    public function actions()
    {
        return $this->hasManyThrough('App\Indicators\Action', 'App\Indicators\Section');
    }

    public function values()
    {
        return $this->morphMany('App\Indicators\Value', 'valueable')->orderBy('month');
    }

    public function getValuesAcum($factor)
    {
        return $this->values->where('factor', $factor)->sum('value');
    }

    public function getValuesAcum2($factor, $commune, $establishment)
    {
        return $this->values->where('factor', $factor)
                            ->when($commune, function($q) use ($commune){
                                return $q->where('commune', $commune);
                            })
                            ->when($establishment, function($q) use ($establishment){
                                return $q->where('establishment', $establishment);
                            })->sum('value');
    }

    public function getCompliance()
    {
        if(isset($this->numerator_acum_last_year)) // REM P
            return $this->getLastValueByFactor('denominador') != 0 ? $this->getLastValueByFactor('numerador') / $this->getLastValueByFactor('denominador') * 100 : 0;
        else
            return $this->getValuesAcum('denominador') != 0 ? $this->getValuesAcum('numerador') / $this->getValuesAcum('denominador') * 100 : 0;
    }

    public function getCompliance2($commune, $establishment)
    {
        if(isset($this->isNumRemP)) // REM P
            return $this->getLastValueByFactor2('denominador', $commune, $establishment) != 0 ? $this->getLastValueByFactor2('numerador', $commune, $establishment) / $this->getLastValueByFactor2('denominador', $commune, $establishment) * 100 : 0;
        else
            return $this->getValuesAcum2('denominador', $commune, $establishment) != 0 ? $this->getValuesAcum2('numerador', $commune, $establishment) / $this->getValuesAcum2('denominador', $commune, $establishment) * 100 : 0;
    }

    public function getValueByFactorAndMonth($factor, $month)
    {
        $result = $this->values->where('factor', $factor)->where('month', $month)->first();
        return $result != null ? $result->value : null;
    }

    public function getValueByFactorAndMonth2($factor, $month, $commune, $establishment)
    {
        $result = $this->values->where('factor', $factor)->where('month', $month)
                               ->when($commune, function($q) use ($commune){
                                   return $q->where('commune', $commune);
                               })
                               ->when($establishment, function($q) use ($establishment){
                                   return $q->where('establishment', $establishment);
                               })->sum('value');
        return $result != null ? $result : null;
    }

    public function getLastValueByFactor($factor)
    {
        $result = $this->values->where('factor', $factor)->last();
        return $result != null ? $result->value : null;
    }

    public function getLastValueByFactor2($factor, $commune, $establishment)
    {
        if($commune != null){
            $last_item = $this->values->where('factor', $factor)->where('commune', $commune)->last();
            $result = $this->values->where('factor', $factor)->where('commune', $commune)->where('month', $last_item ? $last_item->month : 0)->sum('value');
            return $result != null ? $result : null;
        } else {
            $result = $this->values->where('factor', $factor)->where('establishment', $establishment)->last();
            return $result != null ? $result->value : null;
        }
        // $result = $this->values->where('factor', $factor)
        //                         ->when($commune, function($q) use ($commune){
        //                             return $q->where('commune', $commune);
        //                         })
        //                         ->when($establishment, function($q) use ($establishment){
        //                             return $q->where('establishment', $establishment);
        //                         })->last();
        // return $result != null ? $result->value : null;
    }

    public function getContribution()
    {
        if($this->values->isEmpty()) return 0;
        if(Str::contains(str_replace('≤', '<=', $this->goal), '<=')) return $this->getCompliance() <= preg_replace('/[^0-9.]/', '', $this->goal) ? $this->weighting : 0;
        $result = ($this->getCompliance() * $this->weighting) / preg_replace('/[^0-9.]/', '', $this->goal);
        return $result > $this->weighting ? $this->weighting : (!$this->precision ? $result : 0);
    }

    public function isFactorSourceREM($factor)
    {
        return $factor == 'numerador' ? $this->numerator_source == 'REM' : $this->denominator_source == 'REM';
    }
}
