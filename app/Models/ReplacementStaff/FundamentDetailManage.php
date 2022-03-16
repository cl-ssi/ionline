<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundamentDetailManage extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'name'
    ];

    public function getNameValueAttribute(){
        switch ($this->name) {
            case 'quit':
              return 'Renuncia';
              break;
            case 'allowance without payment':
              return 'Permiso sin goce';
              break;
            case 'vacations':
              return 'Feriado Legal';
              break;
            case 'medical license':
              return 'Licencia Médica';
              break;
            case 'replacement previous announcement':
              return 'Reemplazo previa convocatoria';
              break;
            case 'internal announcement':
              return 'Convocatoria interna';
              break;
            case 'mixed announcement':
              return 'Convocatoria mixta';
              break;
            case '':
            case 'other':
              return 'Otro';
              break;
            case 'remote working':
              return 'Teletrabajo (Funciones no habituales)';
              break;
            case '':
              return '';
              break;
        }
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_fundament_detail_manages';
}
