<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\ImmediatePurchase;
use App\Models\Finance\Receptions\Reception;
use App\Models\Finance\Dte;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fin_purchase_orders';

    protected $fillable = [
        'code',
        'date',
        'data',
        'completed',
        'cenabast',
    ];

    /**
    * The attributes that should be cast.
    *
    * @var array
    */
    protected $casts = [
        'date' => 'datetime:Y-m-d H:i:s',
        'completed' => 'boolean',
        'cenabast' => 'boolean',
        // 'data' => 'object', // Para poder importar desde MP no puedo ocupar esto
    ];

    public function dtes()
    {
        return $this->hasMany(Dte::class,'folio_oc','code');
    }

    public function receptions()
    {
        return $this->hasMany(Reception::class,'purchase_order','code')->where('rejected',false);
    }

    public function rejections()
    {
        return $this->hasMany(Reception::class,'purchase_order','code')->where('rejected',true);
    }

    /**
     * Relación con RequestForm a través de ImmediatePurchase
     */
    public function requestForm()
    {
        return $this->hasOneThrough(
            RequestForm::class,
            ImmediatePurchase::class,
            'po_id', // Foreign key on the ImmediatePurchase table...
            'id', // Foreign key on the RequestForm table...
            'code', // Local key on the Dte table...
            'request_form_id', // Local key on the ImmediatePurchase table...
        );
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
