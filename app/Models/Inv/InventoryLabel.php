<?php

namespace App\Models\Inv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLabel extends Model
{
    use HasFactory;
    protected $table = 'inv_labels';

    protected $fillable = [
        'name',
        'module',
        'color'

    ];
}
