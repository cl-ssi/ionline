<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryAdjustment extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'date','inventory_adjustment_type_id','pharmacy_id','user_id','notes'
    ];

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frm_inventory_adjustments';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date'];

    //relaciones
    public function pharmacy()
    {
        return $this->belongsTo('App\Models\Pharmacies\Pharmacy');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id')->withTrashed();
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Pharmacies\InventoryAdjustmentType','inventory_adjustment_type_id');
    }

    public function receiving()
    {
        return $this->hasOne('App\Models\Pharmacies\Receiving');
    }

    public function dispatch()
    {
        return $this->hasOne('App\Models\Pharmacies\Dispatch');
    }
}
