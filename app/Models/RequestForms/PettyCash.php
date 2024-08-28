<?php

namespace App\Models\RequestForms;

use App\Models\User;
use App\Models\RequestForms\PurchasingProcess;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PettyCash extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'arq_petty_cash';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'amount',
        'receipt_number',
        'receipt_type',
        'file',
        'user_id',
        'purchasing_process_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Get the user that owns the petty cash.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the purchasing process that owns the petty cash.
     *
     * @return BelongsTo
     */
    public function purchasingProcess(): BelongsTo
    {
        return $this->belongsTo(PurchasingProcess::class);
    }
}