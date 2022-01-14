<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnicalEvaluationFile extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'name', 'file'
    ];

    public function user() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function technicalEvaluation() {
        return $this->belongsTo('App\Models\ReplacementStaff\TechnicalEvaluation');
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_technical_evaluation_files';
}
