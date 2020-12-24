<?php

namespace App\Imports;

use App\Models\Assigment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithStartRow;

use Carbon\Carbon;

// HeadingRowFormatter::default('none');

class AssigmentImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Assigment([
          'process'     => $row[0],
          'invoice'  => $row[1],
          'payment_year'  => $row[2],
          'payment_month'  => $row[3],
          'accrual_year'  => $row[4],
          'accrual_month'  => $row[5],
          'rut'  => $row[6],
          'correlative'  => $row[7],
          'payment_correlative'  => $row[8],
          'name'  => $row[9],
          'establishment'  => $row[10],
          'legal_quality'  => $row[11],
          'hours'  => $row[12],
          'bienio'  => $row[13],
          'service'  => $row[14],
          'unity'  => $row[15],
          'porc_est_jorn_prior'  => $row[16],
          'porc_est_compet_prof'  => $row[17],
          'porc_est_cond_especial'  => $row[18],
          'porc_est_riesgo'  => $row[19],
          'porc_est_lugar_aislado'  => $row[20],
          'porc_est_turno_llamada'  => $row[21],
          'porc_est_resid_hosp'  => $row[22],
          'porc_prof_espe_art_16'  => $row[23],
          'assets_total'  => $row[24],
          'base_salary'  => $row[25],
          'antiquity'  => $row[26],
          'experience'  => $row[27],
          'responsibility'  => $row[28],
          'est_jorn_prior'  => $row[29],
          'est_compet_prof'  => $row[30],
          'est_condic_lugar'  => $row[31],
          'zone_asignation'  => $row[32],
          'est_cond_especial'  => $row[33],
          'est_resid_hosp'  => $row[34],
          'est_prog_especiali'  => $row[35],
          'est_riesgo'  => $row[36],
          'est_lugar_aislado'  => $row[37],
          'asig_permanencia'   => $row[38]
        ]);
    }

    // public function headingRow(): int
    // {
    //     return 1;
    // }

    public function startRow(): int
    {
        return 2;
    }
}
