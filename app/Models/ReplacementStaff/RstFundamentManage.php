<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RstFundamentManage extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'name'
    ];

    public function rstDetailFundament() {
        return $this->hasMany('App\Models\ReplacementStaff\RstDetailFundament', 'fundament_manage_id');
    }

    public function getNameValueAttribute(){
        switch ($this->name) {
            case 'replacement':
              return 'Reemplazo';
              break;
            case 'quit':
              return 'Renuncia';
              break;
            case 'expand work position':
              return 'Cargo expansión';
              break;
            case 'other':
              return 'Otro';
              break;
            case 'retirement':
              return 'Retiro o Jubilación';
              break;
            case '':
              return '';
              break;
        }
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_fundament_manages';
}
