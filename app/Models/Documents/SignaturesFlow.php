<?php

namespace App\Models\Documents;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SignaturesFlow extends Model Implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'signatures_file_id', 'type', 'ou_id', 'user_id', 'sign_position', 'status', 'signature_date', 'observation',
    ];

    public function signaturesFile(){
        return $this->belongsTo('App\Models\Documents\SignaturesFile', 'signatures_file_id');
    }

    public function signature(){
        return $this->signaturesFile->signature();
    }

    public function getSignerNameAttribute()
    {
        return User::find($this->user_id)->fullName;
    }

    protected $table = 'doc_signatures_flows';

    protected $dates = ['signature_date'];
}
