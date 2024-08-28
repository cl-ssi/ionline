<?php

namespace App\Models\Agreements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountabilityDetail extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agr_accountability_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'description',
        'docNumber',
        'docProvider',
        'docType',
        'egressDate',
        'egressNumber',
        'paymentType',
        'type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'egressDate' => 'date',
    ];

    /**
     * Get the accountability that owns the accountability detail.
     */
    public function accountability(): BelongsTo
    {
        return $this->belongsTo(Accountability::class);
    }
}