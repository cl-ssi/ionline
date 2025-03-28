<?php

namespace App\Models\Drugs;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Reception extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drg_receptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parte',
        'parte_label',
        'parte_police_unit_id',
        'document_number',
        'document_police_unit_id',
        'document_date',
        'delivery',
        'delivery_run',
        'delivery_position',
        'court_id',
        'imputed',
        'imputed_run',
        'observation',
        'reservado_isp_number',
        'reservado_isp_date',
        'date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date'               => 'datetime',
        'document_date'      => 'date',
        'reservado_isp_date' => 'date',
        'imputed'            => 'encrypted',
        'imputed_run'        => 'encrypted',
    ];

    /**
     * Get the items for the reception.
     */
    public function items(): HasMany
    {
        return $this->hasMany(ReceptionItem::class);
    }

    /**
     * Get the items without precursors for the reception.
     */
    public function itemsWithoutPrecursors(): HasMany
    {
        return $this->hasMany(ReceptionItem::class)->whereNull('dispose_precursor');
    }

    /**
     * Get the court that owns the reception.
     */
    public function court(): BelongsTo
    {
        return $this->belongsTo(Court::class);
    }

    /**
     * Get the police unit for the parte.
     */
    public function partePoliceUnit(): BelongsTo
    {
        return $this->belongsTo(PoliceUnit::class, 'parte_police_unit_id');
    }

    /**
     * Get the police unit for the document.
     */
    public function documentPoliceUnit(): BelongsTo
    {
        return $this->belongsTo(PoliceUnit::class, 'document_police_unit_id');
    }

    /**
     * Get the user that owns the reception.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the manager that owns the reception.
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id')->withTrashed();
    }

    /**
     * Get the lawyer that owns the reception.
     */
    public function lawyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lawyer_id')->withTrashed();
    }

    /**
     * Get the destruction for the reception.
     */
    public function destruction(): HasOne
    {
        return $this->hasOne(Destruction::class);
    }

    // relación con destrucion pero solo los trashed
    public function deletedDestructions(): HasMany
    {
        return $this->hasMany(Destruction::class)->onlyTrashed();
    }

    /**
     * Get the sample to ISP for the reception.
     */
    public function sampleToIsp(): HasOne
    {
        return $this->hasOne(SampleToIsp::class);
    }

    /**
     * Get the record to court for the reception.
     */
    public function recordToCourt(): HasOne
    {
        return $this->hasOne(RecordToCourt::class);
    }

    /**
     * Check if the reception was destructed.
     */
    public function wasDestructed(): bool
    {
        return isset($this->destruction);
    }

    /**
     * Check if the reception has items for destruction.
     */
    public function haveItemsForDestruction(): HasMany
    {
        return $this->hasMany(ReceptionItem::class)->where('destruct', '>', 0);
    }

    /**
     * Check if the reception has items.
     */
    public function haveItems(): bool
    {
        return count($this->items) > 0;
    }

    /**
     * Scope a query to search receptions by ID or sample number.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $id)
    {
        if ($id != '') {
            return $query->where('id', $id)->orWhereHas('sampleToISP', function ($q) use ($id) {
                $q->where('number', $id);
            });
        } else {
            return $query;
        }
    }

    /**
     * Formatea un número decimal con reglas personalizadas:
     * - Sin decimales si es entero.
     * - Un decimal si termina en ,x00.
     * - Dos decimales si termina en ,xx0.
     * - Tres decimales si tiene decimales significativos.
     */
    public static function formatDecimalStatic(?float $value): ?string
    {
        if ($value === null) return null;

        if (fmod($value, 1) == 0) {
            return number_format($value, 0, ',', '.');
        }

        $formatted = number_format($value, 3, ',', '.');

        if (preg_match('/,(\d)00$/', $formatted)) {
            return number_format($value, 1, ',', '.');
        } elseif (preg_match('/,(\d\d)0$/', $formatted)) {
            return number_format($value, 2, ',', '.');
        }

        return $formatted;
    }
}
