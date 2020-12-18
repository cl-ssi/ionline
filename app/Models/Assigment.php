<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assigment extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'process', 'invoice', 'payment_year', 'payment_month', 'accrual_year', 'accrual_month', 'rut', 'correlative', 'payment_correlative',
        'name', 'establishment', 'legal_quality', 'hours', 'bienio', 'service', 'unity', 'porc_est_jorn_prior',  'porc_est_compet_prof', 'porc_est_cond_especial',
         'porc_est_riesgo', 'porc_est_lugar_aislado', 'porc_est_turno_llamada', 'porc_est_resid_hosp', 'porc_prof_espe_art_16', 'assets_total', 'base_salary', 'antiquity',
         'experience', 'responsibility', 'est_jorn_prior', 'est_compet_prof', 'est_condic_lugar', 'zone_asignation', 'est_cond_especial', 'est_resid_hosp', 'est_prog_especiali',
          'est_riesgo', 'est_lugar_aislado', 'asig_permanencia'
    ];

    protected $table = 'as_assignments';
}
