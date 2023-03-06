<?php

namespace App\Models\Warehouse;

use App\Models\Parameters\Program;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ControlItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'wre_control_items';

    protected $fillable = [
        'quantity',
        'balance',
        'confirm',
        'correlative_po',
        'inventory',
        'unit_price',
        'control_id',
        'program_id',
        'product_id',
        'unit_id', /* TODO: Por definir el uso */
    ];

    public function control()
    {
        return $this->belongsTo(Control::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function isConfirmed()
    {
        return $this->confirm == true;
    }

    public function getStatusAttribute()
    {
        return $this->isConfirmed() ? 'confirmado' : 'rechazado';
    }

    public function getColorAttribute()
    {
        return $this->isConfirmed() ? 'success' : 'danger';
    }

    public function getProgramNameAttribute()
    {
        $programName = 'Sin Programa';
        if($this->program)
            $programName = $this->program->period . " - " . $this->program->name;
        return $programName;
    }

    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->unit_price;
    }

    public function getTaxAttribute()
    {
        $tax = 0;
        if($this->control->purchaseOrder)
        {
            $tax = $this->control->purchaseOrder->tax_percentage;
            if($this->control->purchaseOrder->tax_percentage > 0)
                $tax = $this->total_price * ($this->control->purchaseOrder->tax_percentage / 100);
        }
        return $tax;
    }
}
