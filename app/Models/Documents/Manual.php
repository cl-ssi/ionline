<?php

namespace App\Models\Documents;

use App\Models\Parameters\Module;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manual extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'author_id',
        'version',
        'title',
        'content',
        'modifications',
    ];

    protected $casts = [
        'version'       => 'float',
        'modifications' => 'array',
    ];

    protected $table = 'doc_manuals';

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
