<?php

namespace App\Models\Parameters;

use App\Models\Documents\Manual;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'developers',
        'referentes',
        'start_date',
        'conditions',
        'status',
    ];

    protected $casts = [
        'developers' => 'array',
        'referentes' => 'array',
        'conditions' => 'array',
        'start_date' => 'datetime',
    ];

    protected $table = 'cfg_modules';

    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }

    public function manuals(): HasMany
    {
        return $this->hasMany(Manual::class);
    }
}
