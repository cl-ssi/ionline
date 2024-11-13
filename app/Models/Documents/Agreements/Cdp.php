<?php

namespace App\Models\Documents\Agreements;

use App\Models\Documents\Document;
use App\Models\Parameters\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cdp extends Model
{
    use SoftDeletes;

    protected $table = 'agr_cdps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'program_id',
        'creator_id',
        'document_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the program.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the creator.
     */
    public function creator(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the document.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
