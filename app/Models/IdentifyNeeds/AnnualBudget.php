<?php

namespace App\Models\IdentifyNeeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Establishment;

class AnnualBudget extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'period',
        'law',
        'item',
        'budget',
        'establishment_id',
    ];

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

    /**
     * Get the item value attribute.
     *
     * @return string|null
     */
    public function getItemValueAttribute(): ?string
    {
        return ucfirst(strtolower($this->item));
    }

    protected $table = 'dnc_annual_budgets';
}
