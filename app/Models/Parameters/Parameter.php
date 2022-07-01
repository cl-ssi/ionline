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
    ];

    public static function get($module, $parameter)
    {
        return Parameter::where('module', $module)->where('parameter', $parameter)->first();
    }
}
