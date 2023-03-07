<?php

namespace App\Models\Rem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Rem\RemPeriodSerie;

class RemPeriod extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'rem_periods';

    protected $fillable = [
        'period',
        'year',
        'month',
    ];

    protected $casts = [
        'period' => 'date',
    ];

    public function series()
    {
        return $this->hasMany(RemPeriodSerie::class, 'period_id', 'id');
    }

    public function getMonthStringAttribute()
    {
        return str_pad($this->month, 2, '0', STR_PAD_LEFT);
    }

    public static function getPivot($user_id, $date)
    {
        $user = User::find($user_id);
        if ($user) {
            return self::getAuthorityFromDate($user->organizational_unit_id, $date, 'manager');
        }
    }
}
