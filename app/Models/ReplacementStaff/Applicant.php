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
        'user_id', 'score', 'observations', 'selected', 'start_date', 'end_date',
        'name_to_replace', 'replacement_reason', 'place_of_performance'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function technicalEvaluation() {
        return $this->belongsTo('App\Models\ReplacementStaff\TechnicalEvaluation');
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_applicants';
}
