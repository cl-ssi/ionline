<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Model;

class PhraseOfTheDay extends Model
{
    protected $table = 'cfg_phrases_of_the_day';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phrase',
    ];
}
