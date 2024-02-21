<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Finance\Dte;

class TgrAccountingPortfolio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fin_tgr_accounting_portfolios';

    protected $fillable = [
        'rut_emisor',
        'folio_documento',
        'razon_social_emisor',
        'cuenta_contable',
        'principal',
        'saldo',
        'tipo_movimiento',
        'fecha',
        'folio',
        'titulo',
        'debe',
        'haber',
        'saldo_acumulado',
        'tipo_documento',
        'numero',
        'origen_transaccion',
        'numero_documento',
        'dte_id',
    ];

    public function dte()
    {
        return $this->belongsTo(Dte::class);
    }
}
