<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'cfg_banks';
}
