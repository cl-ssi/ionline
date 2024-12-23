<?php

namespace App\Models\Parameters;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'type',
        'switch_id',
        'enviroment',
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table = 'cfg_access_logs';

    public function user(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function switchUser(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class, 'switch_id')->withTrashed();
    }
}
