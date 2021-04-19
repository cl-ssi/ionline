<?php

namespace App\Models\Suitability;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'psi_results';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'total_points',
        'request_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\UserExternal', 'user_id');
    }

    public function psirequest()
    {
        return $this->belongsTo('App\Models\Suitability\PsiRequest', 'request_id');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class,'psi_question_result')->withPivot(['option_id', 'points','request_id']);
    }

    public function signedCertificate()
    {
        return $this->belongsTo('App\Models\Documents\SignaturesFile', 'signed_certificate_id');
    }

}
