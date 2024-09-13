<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LogModule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'conditions',
    ];

    protected $casts = [
        'conditions' => 'array',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }
}
