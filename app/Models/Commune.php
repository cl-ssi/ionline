<?php

namespace App\Models;

use App\Models\Establishment;
use App\Models\Agreements\Agreement;
use App\Models\Parameters\Locality;
use App\Models\Parameters\Municipality;
use App\Models\Programmings\CommuneFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Commune extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get the agreements for the commune.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agreements(): HasMany
    {
        return $this->hasMany(Agreement::class);
    }

    /**
     * Get the establishments for the commune.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function establishments(): HasMany
    {
        return $this->hasMany(Establishment::class);
    }

    /**
     * Get the municipality for the commune.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function municipality(): HasOne
    {
        return $this->hasOne(Municipality::class);
    }

    /**
     * Get the commune files for the commune.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function communeFiles(): HasMany
    {
        return $this->hasMany(CommuneFile::class);
    }

    /**
     * Get the localities for the commune.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function localities(): HasMany
    {
        return $this->hasMany(ClLocality::class);
    }
}