<?php

namespace App\Models\Mammography;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MammographySlot extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function day() {
        return $this->belongsTo('\App\Models\Mammography\MammographyDay', 'mammography_day_id');
    }

    protected $fillable = [
        'start_at','end_at','available','used','day_id'
    ];

    protected $dates = [
        'start_at','end_at'
    ];

    protected $table = 'mammography_slots';
}
