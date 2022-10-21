<?php

namespace App\Models\Rem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRem extends Model
{
    use HasFactory;    
    use SoftDeletes;

    public $table = 'rem_users';
}
