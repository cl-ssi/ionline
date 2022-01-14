<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestFormFile extends Model
{
    use SoftDeletes;
    public $table = "arq_request_form_files";

    protected $fillable = [
        'file', 'name'
    ];

    public function getCreationDateAttribute()
    {
      return Carbon::parse($this->created_at)->format('d-m-Y H:i:s');
    }

    public function request_form() {
        return $this->belongsTo('App\RequestForms\RequestForm');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }


}
