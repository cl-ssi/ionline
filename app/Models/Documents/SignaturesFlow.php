<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SignaturesFlow extends Model Implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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

    protected $table = 'doc_signatures_flows';

    protected $dates = ['signature_date'];
}
