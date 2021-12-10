<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'run', 'dv', 'name'
    ];

    protected $table = 'cfg_suppliers';
}
