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

    public static function get($module, $parameter)
    {
        $parameter = Parameter::where('module', $module)->where('parameter', $parameter)->first();
        if(isset($parameter)) return $parameter->value;
        else return null;
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }
}
