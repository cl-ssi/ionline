<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'ind_actions';
    protected $fillable = ['number', 'name', 'verification_means', 'numerator', 'numerator_source',
                           'denominator', 'denominator_source', 'weighting', 'section_id', 'target_type'];

    public function section()
    {
        return $this->belongsTo('App\Indicators\Section');
    }

    public function values()
    {
        return $this->hasMany('App\Indicators\Value')->orderBy('month');
    }

    public function compliances()
    {
        return $this->hasMany('App\Indicators\ComplianceCalc');
    }

    public function getValuesAcum($factor)
    {
        return $this->values->where('factor', $factor)->sum('value');
    }

    public function getCompliance()
    {
        return $this->getValuesAcum('denominador') != 0 ? $this->getValuesAcum('numerador') / $this->getValuesAcum('denominador') * 100 : 0;
    }

    public function getComplianceAssigned()
    {
        $result = $this->getCompliance();
        foreach($this->compliances as $compliance)
            if($this->getOperation($compliance->left_result_value, $result, $compliance->left_result_operator) && $this->getOperation($result, $compliance->right_result_value, $compliance->right_result_operator))
                return $compliance;

        return null;
    }

    public function getOperation($a, $b, $op){
        switch($op){
            case '<' : return $a < $b;
            case '<=': return $a <= $b;
            case '=': return $a == $b;
            case '>' : return $a > $b;
            case '>=': return $a >= $b;
            default  : return true;
        }
    }

    public function getValueByFactorAndMonth($factor, $month)
    {
        $result = $this->values->where('factor', $factor)->where('month', $month)->first();
        return $result != null ? $result->value : 0;
    }

    public function isActionWithFactorSource()
    {
        return $this->numerator_source != null || $this->denominator_source != null;
    }
}
