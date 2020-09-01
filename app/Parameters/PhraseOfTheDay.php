<?php

namespace App\Parameters;

use Illuminate\Database\Eloquent\Model;

class PhraseOfTheDay extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phrase'
    ];

    protected $table = 'cfg_phrases_of_the_day';
}
