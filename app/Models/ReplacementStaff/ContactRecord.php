<?php

namespace App\Models\ReplacementStaff;

use App\Models\ReplacementStaff\ReplacementStaff;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ContactRecord extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rst_contact_records';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'replacement_staff_id',
        'contact_record_user_id',
        'type',
        'contact_date',
        'observation'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'contact_date' => 'datetime'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get the replacement staff that owns the contact record.
     *
     * @return BelongsTo
     */
    public function replacementStaff(): BelongsTo
    {
        return $this->belongsTo(ReplacementStaff::class);
    }

    /**
     * Get the user that owns the contact record.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contact_record_user_id')->withTrashed();
    }
}