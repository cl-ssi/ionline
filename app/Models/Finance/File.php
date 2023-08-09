<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Finance\Dte;

class File extends Model
{
    use HasFactory;

    protected $table = 'fin_files';

    protected $fillable = [
        'file',
        'name',
        'payment_doc_id',
        'dte_id',
        'request_form_id',
    ];

    public function dte()
    {
        return $this->belongsTo(Dte::class, 'dte_id');
    }
}
