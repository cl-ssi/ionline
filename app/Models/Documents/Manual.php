<?php

namespace App\Models\Documents;

use App\Models\Parameters\Module;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manual extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'module_id',
        'author_id',
        'version',
        'title',
        'content',
        'modifications',
        'file',
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

    /**
     * Get the approval model.
     */
    public function approval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable');
    }


    public function createApproval(): void
    {
        $this->approval()->create([
            "module" => "Manuales",
            "module_icon" => "bi bi-book",
            "subject" => $this->title . ' ' . $this->version,
            "document_route_name" => "documents.manuals.show",
            "document_route_params" => json_encode([
                "manual" => $this->id,
            ]),
            /* (Opcional) De preferncia enviar la aprobación a la OU */
            "sent_to_ou_id" => 20,
        ]);
    }
}
