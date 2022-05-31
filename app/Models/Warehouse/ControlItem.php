<?php

namespace App\Models\Warehouse;

use App\Models\Cfg\Program;
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
        'control_id',
        'program_id',
        'product_id',
        'unit_id', // TODO: Por definir el uso
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
        return $this->belongsTo(Product::class, 'product_id');
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
            $programName = $this->program->name;
        return $programName;
    }
}
