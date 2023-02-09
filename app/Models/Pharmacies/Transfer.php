<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'quantity', 'remarks'
    ];

    protected $table = 'frm_transfers';

    public function establishment_from()
    {
        return $this->belongsTo('App\Models\Pharmacies\Establishment', 'from');
    }

    public function establishment_to()
    {
        return $this->belongsTo('App\Models\Pharmacies\Establishment', 'to');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Pharmacies\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
}
