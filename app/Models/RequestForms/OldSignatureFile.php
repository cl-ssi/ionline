<?php

namespace App\Models\RequestForms;

use App\Models\Documents\SignaturesFile;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class OldSignatureFile extends Model
{
    use SoftDeletes;
    public $table = "arq_old_signatures_files";

    protected $fillable = [
        'request_form_id', 'old_signature_file_id'
    ];

    // public function getCreationDateAttribute()
    // {
    //   return Carbon::parse($this->created_at)->format('d-m-Y H:i:s');
    // }

    public function requestForm() {
        return $this->belongsTo(RequestForm::class);
    }

    public function signedFile()
    {
        return $this->belongsTo(SignaturesFile::class, 'old_signature_file_id');
    }


}
