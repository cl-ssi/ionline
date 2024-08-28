<?php

namespace App\Models\Documents;

use App\Models\Documents\Document;
use App\Models\Documents\Parte;
use App\Models\Documents\Signature;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doc_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'doc_digital',
        'partes_exclusive',
        'description'
    ];

    /**
     * Get the documents for the type.
     *
     * @return HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the partes for the type.
     *
     * @return HasMany
     */
    public function partes(): HasMany
    {
        return $this->hasMany(Parte::class);
    }

    /**
     * Get the signatures for the type.
     *
     * @return HasMany
     */
    public function signatures(): HasMany
    {
        return $this->hasMany(Signature::class);
    }
}