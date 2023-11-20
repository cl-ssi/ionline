<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name',
        'path',
        'type',
        'fileable_type',
        'fileable_id',
    ];

    /**
     * Get the polymorphic  parent fileable model:
     * - Reception
     * - 
     * - 
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
