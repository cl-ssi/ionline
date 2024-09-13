<?php

namespace App\Models\Documents;

use App\Models\Parameters\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manual extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'module_id',
        'content',
    ];

    protected $casts = [
        //
    ];

    protected $table = 'doc_manuals';

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
