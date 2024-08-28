<?php

namespace App\Models\Requirements;

use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    // use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'req_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'organizational_unit_id'
    ];

    /**
     * Get the organizational unit that owns the category.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    /**
     * Get the requirements for the category.
     *
     * @return HasMany
     */
    public function requirements(): HasMany
    {
        return $this->hasMany(Requirement::class);
    }

    /**
     * Scope a query to search categories.
     *
     * @param $query
     * @param $request
     * @return mixed
     */
    public function scopeSearch($query, $request)
    {
        if ($request != "") {
            $query->where('name', 'LIKE', '%' . $request . '%');
        }

        return $query;
    }
}