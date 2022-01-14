<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignEvaluation extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'to_user_id', 'observation'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'from_user_id')->withTrashed();
    }

    public function userAssigned() {
        return $this->belongsTo('App\User', 'to_user_id')->withTrashed();
    }

    public function requestReplacementStaff() {
        return $this->belongsTo('App\Models\ReplacementStaff\RequestReplacementStaff');
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_assign_evaluations';
}
