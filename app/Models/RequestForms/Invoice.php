<?php

namespace App\Models\RequestForms;

use App\Models\Warehouse\Control;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'arq_invoices';

    protected $fillable = [
        'number',
        'date',
        'amount',
        'url',
        'control_id',
    ];

    public $dates = [
        'date',
    ];

    public function control()
    {
        return $this->belongsTo(Control::class);
    }

    public function getLinkAttribute()
    {
        return route('warehouse.download-invoice',$this->id);
    }
}
