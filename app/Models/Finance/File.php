<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
