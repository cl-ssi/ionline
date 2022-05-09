<?php

namespace App\Models\Warehouse;

use App\Models\Cfg\Program;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Control extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'wre_controls';

    protected $fillable = [
        'type',
        'adjust_inventory',
        'date',
        'note',
        'store_id',
        'program_id',
        'origin_id',
        'destination_id',
    ];

    protected $dates = [
        'date'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function origin()
    {
        return $this->belongsTo(Origin::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function items()
    {
        return $this->hasMany(ControlItem::class, 'control_id');
    }

    public function isReceiving()
    {
        return $this->type == 1;
    }

    public function isDispatch()
    {
        return $this->type == 0;
    }

    public function getTypeFormatAttribute()
    {
        return ($this->type) ? 'Ingreso' : 'Egreso';
    }

    public function getDateFormatAttribute()
    {
        return $this->date->format('Y-m-d');
    }

    public function getShortNoteAttribute()
    {
        return Str::limit($this->note, 20);
    }

    public function getProgramNameAttribute()
    {
        $programName = 'Sin Programa';
        if($this->program)
            $programName = $this->program->name;
        return $programName;
    }

    public function getTypeDispatchAttribute()
    {
        $name = null;
        if($this->isDispatch() && $this->isAdjustInventory())
        {
            $name = 'Ajuste de Inventario';
        }
        return $name;
    }

    public function getAdjustInventoryFormatAttribute()
    {
        $name = null;
        if($this->isDispatch())
        {
            if($this->isAdjustInventory())
                $name = 'Si';
            else
                $name = 'No';
        }
        return $name;
    }

    public function isAdjustInventory()
    {
        return $this->adjust_inventory == 1;
    }
}
