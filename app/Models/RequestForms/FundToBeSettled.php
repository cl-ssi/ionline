<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundToBeSettled extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'date', 'amount', 'document_id'
    ];

    protected $table = 'arq_funds_to_be_settled';
}
