<?php

namespace App\Models\Mammography;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MammographyDay extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'day','exam_available','exam_used'
    ];

    public function slots() {
        return $this->hasMany('\App\Models\Mammography\MammographySlot');
    }

    protected $dates = [
      'day'
    ];

    protected $table = 'mammography_days';

}
