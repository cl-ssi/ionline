<?php

namespace App\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Computer extends Model
{
    //
    protected $fillable = [
        'id', 'type', 'brand', 'model', 'serial', 'hostname', 'domain', 'ip', 'mac_address', 'operating_system', 'processor', 'ram', 'hard_disk',
        'inventory_number', 'active_type', 'intesis_id', 'comment', 'status', 'office_serial', 'windows_serial', 'place_id'
    ];

    public function users() {
    	return $this->belongsToMany('\App\User','res_computer_user')->withTimestamps();
    }

    public function place() {
        return $this->belongsTo('App\Parameters\Place');
    }

    public function scopeSearch($query, $search) {
        if($search != "") {
            return $query->where('brand', 'LIKE', '%'.$search.'%')
                         ->orWhere('model', 'LIKE', '%'.$search.'%')
                         ->orWhere('ip', 'LIKE', '%'.$search.'%')
                         ->orWhere('serial', 'LIKE', '%'.$search.'%')
                         ->orWhere('inventory_number', 'LIKE', '%'.$search.'%');
        }
    }

    public function tipo(){
          switch ($this->type) {
            case 'desktop':
              $valor='PC Escritorio';
              break;
            case 'all-in-one':
              $valor='PC all-in-one';
              break;
            case 'notebook':
              $valor='PC Notebook';
              break;
            case 'other':
              $valor='PC Otro';
              break;
            default:
              $valor='';
              break;
          }
          return $valor;
        }

        public function tipoActivo(){
              switch ($this->active_type) {
                case 'leased':
                  $valor='Arrendado';
                  break;
                case 'own':
                  $valor='Propio';
                  break;
                case 'user':
                  $valor='Usuario';
                  break;
                default:
                  $valor='';
                  break;
              }
              return $valor;
            }

    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'res_computers';
}
