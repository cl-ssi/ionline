<?php

namespace App\Models;

use App\Models\Rrhh\OrganizationalUnit;
use App\Observers\CommentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([CommentObserver::class])]
class Comment extends Model
{
    use SoftDeletes;

    /**
     * Ejemplo de uso (organizationalUnit y establishment se llenan automáticamente):
     */
    // $comment = $modelo->comments()->create([
    //    'body' => 'Comentario de prueba',
    //    'is_from_system' => true, //opcional si es un comentario del sistema
    // ]);

    protected $fillable = [
        'body',
        'is_from_system',
        'author_id',
        'organizational_unit_id',
        'establishment_id',
        'commentable_id',
        'commentable_type',
    ];

    protected $casts = [
        'is_from_system' => 'boolean',
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'organizational_unit_id');
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

}
