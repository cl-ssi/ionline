<?php

namespace App\Models\RequestForms;

use App\Models\Warehouse\Control;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'arq_invoices';

    protected $fillable = [
        'number',
        'date',
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
}
