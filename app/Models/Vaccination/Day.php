<?php

namespace App\Models\Vaccination;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    public function slots() {
        return $this->hasMany('\App\Models\Vaccination\Slot');
    }

    protected $fillable = ['day','first_dose_available','first_dose_used'];
    protected $table = 'vac_days';
    protected $dates = ['day'];
}
