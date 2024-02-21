<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAdjustmentType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frm_inventory_adjustment_types';

    //relaciones
    // public function dispatch()
    // {
    //     return $this->belongsTo('App\Models\Pharmacies\Dispatch');
    // }
}
