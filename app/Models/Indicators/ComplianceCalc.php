<?php

namespace App\Models\Indicators;

use Illuminate\Database\Eloquent\Model;

class ComplianceCalc extends Model
{
    protected $table = 'ind_compliance_calc';
    protected $fillable = ['left_result_value', 'left_result_operator', 'right_result_value',
                           'right_result_operator', 'result_text', 'compliance_value', 'compliance_text'];

    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    public function getLeftResultOperatorInverseAttribute()
    {
        switch($this->left_result_operator){
            case '<' : return '>';
            case '<=': return '>=';
            case '>' : return '<';
            case '>=': return '<=';
            default  : return $this->left_result_operator;
        }
    }
}
