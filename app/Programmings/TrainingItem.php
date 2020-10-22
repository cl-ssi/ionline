<?php

namespace App\Programmings;

use Illuminate\Database\Eloquent\Model;

class TrainingItem extends Model
{
    protected $table = 'pro_training_items';

    protected $fillable = ['linieamiento_estrategico', 'temas', 'objetivos_educativos','med_odont_qf', 'otros_profesionales', 'tec_nivel_superior',
    'tec_salud', 'administrativo_salud', 'auxiliares_salud','total', 'num_hr_pedagodicas', 'item_cap',
    'fondo_muni', 'otro_fondo', 'total_presupuesto_est','org_ejecutor', 'coordinador', 'fecha_ejecucion'];

}
