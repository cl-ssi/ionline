<?php

namespace App\Models\Summary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'sum_events';

    protected $fillable = [
        'id',
        'name',
        'duration',
        'user',
        'file',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getUserTextAttribute()
    {
        return $this->user ? 'Sí' : 'No';
    }

    public function getFileTextAttribute()
    {
        return $this->file ? 'Sí' : 'No';
    }


}
