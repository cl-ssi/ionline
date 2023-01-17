<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstablishmentType extends Model
{
    use HasFactory;
    protected $fillable = [        
        'name'
    ];
}
