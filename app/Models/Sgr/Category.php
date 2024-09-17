<?php

namespace App\Models\Sgr;

use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

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
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'sgr_categories';

    // relaciones

    public function organizationalUnit(): BelongsTo {
        return $this->belongsTo(OrganizationalUnit::class);
    }
}
