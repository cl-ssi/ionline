<?php

namespace App\Models\Summary;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Summary\EventType;

class Type extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name',
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'sum_types';

    public function eventTypes()
    {
        return $this->hasMany(EventType::class,'summary_type_id')
            ->orderBy('summary_actor_id')
            ->orderBy('name');
    }

}
