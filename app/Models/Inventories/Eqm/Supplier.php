<?php

namespace App\Models\Inventories\Eqm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status'
    ];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'eqm_suppliers';
}
