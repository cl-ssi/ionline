<?php

namespace App\Models\Rem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class RemFile extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'rem_files';

    protected $fillable = [
        'period',
        'establishment_id',
        'filename',
        'locked',
        'rem_period_series_id'
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'period',
    ];

    public function establishment() {
        return $this->belongsTo('App\Models\Establishment');
    }

}
