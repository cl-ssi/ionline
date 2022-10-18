<?php

namespace App\Models\Inv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryLabel extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'inv_labels';

    protected $fillable = [
        'name',
        'module',
        'color'
    ];
}
