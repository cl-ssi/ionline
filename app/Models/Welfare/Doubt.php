<?php

namespace App\Models\Welfare;


use Illuminate\Database\Eloquent\Model;

class Doubt extends Model
{
    
    protected $table = 'well_ami_doubts';

    protected $fillable = [
        'nombre_completo',
        'rut',
        'correo',
        'establecimiento',
        'motivo',
        'consulta',
        'respuesta',
        'questioner_id',
        'question_at',
        'answerer_id',
        'answer_at',
    ];

    


}
