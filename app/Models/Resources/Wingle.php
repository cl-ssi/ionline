<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Model;

class Wingle extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'res_wingles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand',
        'company',
        'imei',
        'model',
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // Add any other attributes that need casting here
    ];
}
