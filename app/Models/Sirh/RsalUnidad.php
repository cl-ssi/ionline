<?php

namespace App\Models\Sirh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsalUnidad extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'unid_codigo',
        'unid_descripcion',
        'unid_codigo_deis',
        'unid_comuna',
        'unid_cod_dipres'
    ];

    protected $table = 'sirh_rsal_unidades';

    // json de ejemplo integración mirth/sirh

    // {
    //     "model_route": "App\\Models\\Sirh\\RsalUnidad",
    //     "model_data": [
    //         {
    //             "UNID_CODIGO": "Ejemplo de código 1",
    //             "UNID_DESCRIPCION": "Ejemplo de ingreso 1",
    //             "UNID_CODIGO_DEIS": "Ejemplo de código DEIS 1",
    //             "UNID_COMUNA": "Ejemplo comuna 1",
    //             "UNID_COD_DIPRES": "Ejemplo código DIPRES 1"
    //         },
    //         {
    //             "UNID_CODIGO": "Ejemplo de código 2",
    //             "UNID_DESCRIPCION": "Ejemplo de ingreso 2",
    //             "UNID_CODIGO_DEIS": "Ejemplo de código DEIS 2",
    //             "UNID_COMUNA": "Ejemplo comuna 2",
    //             "UNID_COD_DIPRES": "Ejemplo código DIPRES 2"
    //         },
    //         {
    //             "UNID_CODIGO": "Ejemplo de código 3",
    //             "UNID_DESCRIPCION": "Ejemplo de ingreso 3",
    //             "UNID_CODIGO_DEIS": "Ejemplo de código DEIS 3",
    //             "UNID_COMUNA": "Ejemplo comuna 3",
    //             "UNID_COD_DIPRES": "Ejemplo código DIPRES 3"
    //         }
    //     ],
    //     "column_mapping": {
    //         "UNID_CODIGO": "unid_codigo",
    //         "UNID_DESCRIPCION": "unid_descripcion",
    //         "UNID_CODIGO_DEIS": "unid_codigo_deis",
    //         "UNID_COMUNA": "unid_comuna",
    //         "UNID_COD_DIPRES": "unid_cod_dipres"
    //     }
    // }
}
