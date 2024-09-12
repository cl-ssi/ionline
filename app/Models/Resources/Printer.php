<?php

namespace App\Models\Resources;

use App\Models\Parameters\Place;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Printer extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'res_printers';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    protected $fillable = [
        'id',
        'serial',
        'type',
        'brand',
        'model',
        'ip',
        'mac_address',
        'active_type',
        'comment',
        'status',
        'place_id',
    ];

    public function users()
    {
        return $this->belongsToMany('\App\Models\User', 'res_printer_user')->withTimestamps();
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

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

    public function tipo()
    {
        switch ($this->type) {
            case 'printer':
                $valor = 'Impresora';
                break;
            case 'scanner':
                $valor = 'Escáner';
                break;
            case 'plotter':
                $valor = 'Plóter';
                break;
            case 'other':
                $valor = 'Otra Impresora';
                break;
            default:
                $valor = '';
                break;
        }

        return $valor;
    }

    public function tipoActivo()
    {
        switch ($this->active_type) {
            case 'leased':
                $valor = 'Arrendado';
                break;
            case 'own':
                $valor = 'Propio';
                break;
            case 'user':
                $valor = 'Usuario';
                break;
            default:
                $valor = '';
                break;
        }

        return $valor;
    }
}
