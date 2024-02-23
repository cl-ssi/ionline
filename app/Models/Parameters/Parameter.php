<?php

namespace App\Models\Parameters;

use App\Models\Scopes\ParameterScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

use App\Models\Establishment;

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
        'establishment_id',
    ];

    // /**
    //  * The "booted" method of the model.
    //  */
    // protected static function booted(): void
    // {
    //     static::addGlobalScope(new ParameterScope);
    // }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($parameter) {
    //         if(is_null($parameter->establishment_id)){
    //             $parameter->establishment_id = auth()->user()->organizationalUnit->establishment_id;
    //         }
    //     });
    // }

    public static function get($module, $parameter, $establishment_id = null)
    {
        $query = Parameter::where('module', $module);
            // ->where('parameter', $parameter);
        if(is_array($parameter)){
            $query->whereIn('parameter', $parameter);
        }else{
            $query->where('parameter', $parameter);
        }

        if ($establishment_id !== null) {
            if(is_array($establishment_id)){
                $query->whereIn('establishment_id', $establishment_id);
            }else{
                $query->where('establishment_id', $establishment_id);
            }
        }

        /** 
         * @alupa: 2021-07-20
         * $query->first()->value da error si el parámetro no existe, debería retornar null.
         */
        if(isset($parameter)) return is_array($parameter) || is_array($establishment_id) ? $query->pluck('value')->toArray() : ($query->first()->value ?? null);
        else return null;
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }
}
