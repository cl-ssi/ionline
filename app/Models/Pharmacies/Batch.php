<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use HasFactory;
    use SoftDeletes;
    //
    protected $fillable = [
        'id','product_id','due_date','batch','count'
    ];

    protected $table = 'frm_batchs';

    public function dispatchItems()
    {
        return $this->hasMany('App\Models\Pharmacies\DispatchItem');
    }

    public function purchaseItems()
    {
        return $this->hasMany('App\Models\Pharmacies\PurchaseItem');
    }

    public function receivingItems()
    {
        return $this->hasMany('App\Models\Pharmacies\ReceivingItem');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['due_date'];
}
