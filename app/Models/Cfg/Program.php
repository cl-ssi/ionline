<?php

namespace App\Models\Cfg;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cfg_programs';

    protected $fillable = [
        'name',
        'start',
        'end',
    ];
}
