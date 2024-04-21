<?php

namespace App\Models\Rrhh;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rrhh_attendances';

    protected $fillable = [
        'user_id',
        'date',
        'records',
        'report_date',
    ];

    protected $casts = [
        'date' => 'date',
        'report_date' => 'date',
    ];

    // Relacion con user

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
