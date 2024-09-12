<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active_type',
        'brand',
        'comment',
        'id',
        'ip',
        'mac_address',
        'model',
        'place_id',
        'serial',
        'status',
        'type',
    ];

    /**
     * Scope a query to search reports.
     */
    public function scopeSearch($query, $search)
    {
        if ($search != '') {
            return $query->where('serial', 'LIKE', '%'.$search.'%')
                ->orWhere('type', 'LIKE', '%'.$search.'%')
                ->orWhere('brand', 'LIKE', '%'.$search.'%')
                ->orWhere('model', 'LIKE', '%'.$search.'%')
                ->orWhere('ip', 'LIKE', '%'.$search.'%')
                ->orWhere('mac_address', 'LIKE', '%'.$search.'%')
                ->orWhere('active_type', 'LIKE', '%'.$search.'%');
        }
    }
}
