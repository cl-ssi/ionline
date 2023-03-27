<?php

namespace App\Models\Indicators;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'ind_actions';
    protected $fillable = ['number', 'name', 'verification_means', 'numerator', 'numerator_source',
                           'denominator', 'denominator_source', 'weighting', 'section_id', 'target_type',
                           'numerator_cods', 'numerator_cols', 'denominator_cods', 'denominator_cols', 'is_accum'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function values()
    {
        return $this->morphMany(Value::class, 'valueable')->orderBy('month');
    }

    public function compliances()
    {
        return $this->hasMany(ComplianceCalc::class);
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
        return ($this->numerator_cols != null &&  $this->numerator_cols) != null || ($this->denominator_cols != null && $this->denominator_cods != null);
    }
}
