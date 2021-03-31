<?php

namespace App\Models\Suitability;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PsiRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'psi_requests';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'job',
        'country',
        'start_date',
        'disability',
    ];

    public function user(){
        return $this->belongsTo('App\Models\UserExternal','user_external_id');
      }

    public function school(){
        return $this->belongsTo('App\Models\Suitability\School','school_id');
      }

      public function result(){
        return $this->belongsTo('App\Models\Suitability\Result','id','request_id');
      }


}
