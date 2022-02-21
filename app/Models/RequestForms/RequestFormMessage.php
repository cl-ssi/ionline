<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\User;

class RequestFormMessage extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id', 'message'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function requestForm() {
        return $this->belongsTo(RequestForm::class, 'request_form_id');
    }

    protected $table = 'arq_request_form_messages';
}
