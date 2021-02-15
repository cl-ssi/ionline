<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SignaturesFile extends Model
{
    use HasFactory;
//    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'signature_id', 'file', 'file_type', 'signed_file',
    ];

    public function signaturesFlows(){
        return $this->hasMany('App\Models\Documents\SignaturesFlow', 'signatures_file_id');
    }



    protected $table = 'doc_signatures_files';
}
