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
        'filename',
        'month',
        'year',
        'establishment_id',
        'is_locked',
    ];

    public function establishment() {
        return $this->belongsTo('App\Establishment');
    }

}
