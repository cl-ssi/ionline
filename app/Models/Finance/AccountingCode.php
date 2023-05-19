<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingCode extends Model
{
    use HasFactory;

    public $incrementing = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'description'
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'fin_accounting_codes';
    
}
