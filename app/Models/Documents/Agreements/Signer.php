<?php

namespace App\Models\Documents\Agreements;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Signer extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agr_signers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'appellative',
        'decree',
        'user_id'
    ];

    /**
     * Get the user that owns the signer.
     */
    public function user(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function decreeParagraph(): Attribute
    {
        return Attribute::make(
            get: fn (): string => collect(preg_split('/<\/li>/', $this->decree)) // Divide por </li>
                ->map(fn ($item) => strip_tags(preg_replace('/\.\s*$/', '', trim($item)))) // Elimina etiquetas HTML y espacios extra
                ->filter() // Elimina elementos vacíos
                ->implode('; ') // Une con "; "
        );
    }
}
