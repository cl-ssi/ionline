<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnicalEvaluation extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'date_end'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function requestReplacementStaff() {
        return $this->belongsTo('App\Models\ReplacementStaff\RequestReplacementStaff');
    }

    public function commissions() {
        return $this->hasMany('App\Models\ReplacementStaff\Commission');
    }

    public function applicants() {
        return $this->hasMany('App\Models\ReplacementStaff\Applicant');
    }

    public function technical_evaluation_files() {
        return $this->hasMany('App\Models\ReplacementStaff\TechnicalEvaluationFile');
    }

    public function getStatusValueAttribute() {
        switch($this->technical_evaluation_status) {
          case 'pending':
            return 'Pendiente';
            break;
          case 'complete':
            return 'Completa';
            break;
          case 'rejected':
            return 'Completa';
            break;
        }
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $dates = [
      'date_end'
    ];

    protected $table = 'rst_technical_evaluations';
}
