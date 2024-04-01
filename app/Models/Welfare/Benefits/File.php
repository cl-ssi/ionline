<?php

namespace App\Models\Welfare\Benefits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Welfare\Benefits\Document;

class File extends Model
{
    use HasFactory;
    
    protected $table = 'well_bnf_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'file', 'name', 'well_bnf_request_id', 'document_id'
    ];

    // relaciones
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
