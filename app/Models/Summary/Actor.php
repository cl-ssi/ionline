<?php

namespace App\Models\Summary;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use SoftDeletes;

    protected $table = 'sum_actors';

    protected $fillable = [
        'name',
    ];
}
