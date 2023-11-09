<?php

namespace App\Models\Inv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classification extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'inv_classifications';

    protected $fillable = [
        'id',
        'name',
    ];
}
