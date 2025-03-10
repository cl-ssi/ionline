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

    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    
    protected $fillable = [
        'job',
        'country',
        'start_date',
        'disability',
        'status_inhability',
        'signed_at',
        'test_send_at',
        'approved_at',
        'rejected_at',
        'certificated_at'
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
