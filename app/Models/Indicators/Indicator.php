<?php

namespace App\Models\Indicators;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Indicator extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['number', 'name', 'weighting_by_section', 'evaluated_section_states', 'numerator',  
                           'numerator_source', 'denominator', 'denominator_source', 'numerator_acum_last_year',
                           'numerator_cods', 'numerator_cols', 'denominator_cods', 'denominator_acum_last_year',
                           'denominator_cols', 'goal', 'weighting', 'precision', 'establishment_cods', 'indicatorable_type'];

    public function indicatorable()
    {
        return $this->morphTo();
    }

    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('number');
    }

    public function actions()
    {
        return $this->hasManyThrough(Action::class, Section::class);
    }

    public function values()
    {
        return $this->morphMany(Value::class, 'valueable')->orderBy('id')->orderBy('month');
    }

    public function attachedFiles()
    {
        return $this->morphMany(AttachedFile::class, 'attachable')->orderBy('section');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'indicators_users')
                    ->withPivot('referrer_number')
                    ->withTimestamps()
                    ->orderBy('referrer_number');
    }

    public function getReferrer($number)
    {
        return $this->users()->wherePivot('referrer_number', $number)->first();
    }

    public function getValuesAcum($factor)
    {
        return $this->values->where('factor', $factor)->sum('value');
    }

    public function getValuesBy($commune, $establishment)
    {
        return $this->values->where('factor', 'denominador')->where('commune', $commune)->when($establishment, function($q) use ($establishment){
            return $q->where('establishment', $establishment);
        });
    }
    
    public function getAttachedFilesBy($commune, $establishment)
    {
        return $this->attachedFiles->where('commune', $commune)->when($establishment, function($q) use ($establishment){
            return $q->where('establishment', $establishment);
        });
    }

    public function hasValuesBy($commune, $establishment)
    {
        return $this->values->where('commune', $commune)->when($establishment, function($q) use ($establishment){
            return $q->where('establishment', $establishment);
        })->count() > 0;
    }

    public function hasValueByActivityNameAndMonth($factor, $activity_name, $month, $commune, $establishment)
    {
        return $this->values->where('factor', $factor)->where('activity_name', $activity_name)->where('month', $month)->where('commune', $commune)->when($establishment, function($q) use ($establishment){
                                   return $q->where('establishment', $establishment);
                               })->sum('value') > 0;
    }

    public function getValueByActivityNameAndMonth($factor, $activity_name, $month, $commune, $establishment)
    {
        return $this->values->where('factor', $factor)->where('activity_name', $activity_name)->where('month', $month)->where('commune', $commune)->when($establishment, function($q) use ($establishment){
                                   return $q->where('establishment', $establishment);
                               })->first();
    }

    public function getValuesAcumByActivityName($factor, $activity_name, $commune, $establishment)
    {
        return $this->values->where('factor', $factor)->where('activity_name', $activity_name)->where('commune', $commune)->when($establishment, function($q) use ($establishment){
            return $q->where('establishment', $establishment);
        })->sum('value');
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
        if(isset($this->numerator_acum_last_year)){ // REM P
            $result = $this->getLastValueByFactor('denominador');
            return $result != 0 ? $this->getLastValueByFactor('numerador') / $result * (Str::contains($this->goal, '%') || $this->goal == null ? 100 : 1) : 0;
        }elseif(in_array($this->id, [445,453,441,449])){ // indicador N° 10 en DSSI y Hospital y N° 6 en DSSI y Hospital, metas sanitarias 19.664 año 2022
            return $this->getValuesAcum('numerador');
        }else{
            $result = $this->getValuesAcum('denominador');
            return $result != 0 ? $this->getValuesAcum('numerador') / $result * (Str::contains($this->goal, '%') || $this->goal == null ? 100 : 1) : 0;
        }
    }

    public function getCompliance2($commune, $establishment)
    {
        if(isset($this->isNumRemP)){ // REM P
            $result = $this->getLastValueByFactor2('denominador', $commune, $establishment);
            return $result != 0 ? $this->getLastValueByFactor2('numerador', $commune, $establishment) / $result * 100 : 0;
        }else{
            $result = $this->getValuesAcum2('denominador', $commune, $establishment);
            return $result != 0 ? $this->getValuesAcum2('numerador', $commune, $establishment) / $result * 100 : 0;
        }
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
    }

    public function getContribution()
    {
        if($this->values->isEmpty()) return 0;
        $filteredNumbers = array_filter(preg_split('/[^0-9.]/', $this->goal));
        if(Str::contains(str_replace('≤', '<=', $this->goal), '<=')) return $this->getCompliance() <= reset($filteredNumbers) ? $this->weighting : 0;
        $result = ($this->getCompliance() * $this->weighting) / reset($filteredNumbers);
        return $result > $this->weighting ? $this->weighting : (!$this->precision ? $result : 0);
    }

    public function isFactorSourceREM($factor)
    {
        return $factor == 'numerador' ? $this->numerator_source == 'REM' : $this->denominator_source == 'REM';
    }

    public function getSourceAbbreviated($value)
    {
        $factor = $value == 'numerador' ? $this->numerator_source : $this->denominator_source;
        return Str::contains(mb_strtoupper($factor), 'REM') ? substr($factor, 0, 5) : $factor;
    }

    public function hasEstablishments($establishments, $commune)
    {
        // me indica la cantidad de establecimientos asociados al indicador en el cual hace match con un array de establecimientos X segun comuna
        $count = 0;
        foreach($establishments as $establishment)
            if($establishment->comuna == $commune && Str::contains($this->establishment_cods, $establishment->Codigo)) $count++;
        return $count;
    }
}
