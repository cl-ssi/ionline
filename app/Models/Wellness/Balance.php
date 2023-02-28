<?php

namespace App\Models\Wellness;


use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'well_balances';
    
    protected $fillable = [
        'ano','mes','tipo', 'codigo', 'titulo', 'item', 'asignacion', 'glosa', 'inicial', 'traspaso', 'ajustado', 'ejecutado', 'saldo'
    ];
}
