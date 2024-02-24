<?php

namespace App\Models\Rem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;

    protected $table = "2024secciones";

    public $timestamps = false;

    protected $fillable = [
        'name',
        'serie',
        'nserie',
        'supergroups',
        'supergroups_inline',
        'discard_group',
        'thead',
        'cols',
        'cods',
        'totals',
        'totals_by_prestacion',
        'totals_by_group',
        'totals_first',
        'subtotals',
        'subtotals_first',
        'tfoot',
        'precision'
    ];

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql_rem';
}
