<?php

namespace App\Models\ServiceRequests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    use HasFactory;

    public $table = 'sr_values';

    protected $fillable = [
        'contract_type','work_type','amount', 'validity_from'
    ];
}
