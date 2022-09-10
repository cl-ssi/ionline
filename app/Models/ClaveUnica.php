<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaveUnica extends Model
{
    use HasFactory;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'access_token','response',
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'users_clave_unica';
    
}
