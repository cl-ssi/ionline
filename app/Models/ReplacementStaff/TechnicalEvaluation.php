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
        'end_date'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function requestReplacementStaff() {
        return $this->belongsTo('App\Models\ReplacementStaff\RequestReplacementStaff');
    }

    public function commission() {
        return $this->hasMany('App\Models\ReplacementStaff\Commission');
    }

    public function applicant() {
        return $this->hasMany('App\Models\ReplacementStaff\Applicant');
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

    protected $table = 'rst_technical_evaluations';
}
