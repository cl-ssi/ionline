<?php

namespace App\Models\Rem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemSerie extends Model
{
    use HasFactory;
    public $table = 'rem_series';

    protected $fillable = [
        'name',
    ];
}
