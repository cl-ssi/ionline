<?php

namespace App\Parameters;

use Illuminate\Database\Eloquent\Model;

class Proffesional extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'category'
    ];

    protected $table = 'cfg_professions';
}
