<?php

namespace App\Models\ServiceRequests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ShiftControl extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'service_request_id', 'start_date','end_date','observation'
    ];

    public function serviceRequest(){
      return $this->belongsTo('App\ServiceRequests\ServiceRequest');
    }

    protected $table = 'doc_shift_controls';
}
