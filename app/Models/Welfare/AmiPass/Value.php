<?php

namespace App\Models\Welfare\Amipass;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    use HasFactory;

    protected $table = 'well_ami_values';

    protected $fillable = [
        'period',
        'type',
        'amount'
    ];
}
