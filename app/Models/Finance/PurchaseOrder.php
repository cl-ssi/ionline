<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use App\Models\Finance\Dte;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fin_purchase_orders';

    protected $fillable = [
        'code',
        'date',
        'data',
    ];

    /**
    * The attributes that should be cast.
    *
    * @var array
    */
    protected $casts = [
        'date' => 'datetime:Y-m-d H:i:s',
        // 'data' => 'object', // Para poder importar desde MP no puedo ocupar esto
    ];

    public function dtes()
    {
        return $this->hasMany(Dte::class);
    }

    /**
    * Decodificar el json
    */
    public function getJsonAttribute()
    {
        return json_decode($this->data);
    }

    public function dateFormat($date)
    {
        $parse = Carbon::parse($date);
        return $parse->gt($this->date->sub('1 year')) ? $parse->format('Y-m-d H:i:s') : '';
    }
}
