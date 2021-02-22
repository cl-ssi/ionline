<?php

namespace App\Models\Vaccination;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    public function day() {
        return $this->belongsTo('\App\Models\Vaccination\Day');
    }

    protected $fillable = [
        'start_at','end_at','available','used','day_id'
    ];

    protected $dates = [
        'start_at','end_at'
    ];

    protected $table = 'vac_slots';
}
