<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'replacement_staff_id', 'psycholabor_evaluation_score', 'technical_evaluation_score',
        'observations', 'selected', 'start_date', 'end_date', 'name_to_replace',
        'replacement_reason', 'ou_of_performance_id'
    ];

    public function replacementStaff() {
        return $this->belongsTo('App\Models\ReplacementStaff\ReplacementStaff');
    }

    public function technicalEvaluation() {
        return $this->belongsTo('App\Models\ReplacementStaff\TechnicalEvaluation');
    }

    public function ouPerformance() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'ou_of_performance_id');
    }

    public function getPsyEvaScoreAttribute() {
        if($this->psycholabor_evaluation_score >= 10 && $this->psycholabor_evaluation_score <= 59){
            return 'No recomendable';
        }
        if($this->psycholabor_evaluation_score >= 60 && $this->psycholabor_evaluation_score <= 79){
            return 'Recomendable con observaciones';
        }
        if($this->psycholabor_evaluation_score >= 80){
            return 'Recomendable';
        }
    }

    public function getTechEvaScoreAttribute() {
        if($this->technical_evaluation_score >= 10 && $this->technical_evaluation_score <= 59){
            return 'Mínimas competencias Técnicas';
        }
        if($this->technical_evaluation_score >= 60 && $this->technical_evaluation_score <= 70){
            return 'Regulares competencias Técnicas';
        }
        if($this->technical_evaluation_score >= 71 && $this->technical_evaluation_score <= 80){
            return 'Destacadas Competencias Técnicas';
        }
        if($this->technical_evaluation_score >= 81){
            return 'Sobresalientes competencias Técnicas';
        }
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $dates = [
      'start_date', 'end_date'
    ];

    protected $table = 'rst_applicants';
}
