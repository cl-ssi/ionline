<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $table = 'cfg_parameters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'module',
        'parameter',
        'value',
        'description',
        /* TODO: #148 #147 Incoporar el id_establecimiento, podrían haber parametros iguales en dos establecimientos distintos */
    ];

    public static function get($module, $parameter)
    {
        $parameter = Parameter::where('module', $module)->where('parameter', $parameter)->first();
        if(isset($parameter)) return $parameter->value;
        else return null;
    }
}
