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

    protected $fillable = [
        'brand', 'model', 'company', 'imei', 'password'
    ];
}
