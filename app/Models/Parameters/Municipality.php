<?php

namespace App\Models\Parameters;

use App\Models\ClCommune;
use App\Models\Commune;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipality extends Model
{
    /** Cambio a nueva tabla pendiente */
    protected $table = 'cfg_municipalities';

    protected $fillable = [
        'name',
        'rut',
        'address',
        'emails',
        'commune_id'
    ];

    protected $casts = [
        'emails' => 'array'
    ];

    public function commune(): BelongsTo
    {
        return $this->belongsTo(ClCommune::class);
    }

    public function mayors(): HasMany
    {
        return $this->hasMany(Mayor::class);
    }

    public function emailList(): Attribute
    {
        return Attribute::make(
            get: fn (): string => implode('', array_map(fn ($email) => "<li>{$email}</li>", $this->emails))
        );
    }
}
