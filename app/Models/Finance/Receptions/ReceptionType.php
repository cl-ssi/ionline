<?php

namespace App\Models\Finance\Receptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceptionType extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'fin_reception_types';
    

    protected $fillable = [
        'id',
        'name',
    ];
}
