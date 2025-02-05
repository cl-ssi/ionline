<?php

namespace App\Models\Parameters;

use App\Models\User;
use App\Models\Commune;
use App\Models\ClCommune;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    /**
     * The user that belong to the municipality.
     */
    public function users(): BelongsToMany|Builder
    {
        return $this->belongsToMany(User::class, 'cfg_municipality_users')
            ->withTimestamps()
            ->withTrashed();
    }

    public function emailList(): Attribute
    {
        return Attribute::make(
            get: fn (): string => implode('', array_map(fn ($email) => "<li>{$email}</li>", $this->emails))
        );
    }
}
