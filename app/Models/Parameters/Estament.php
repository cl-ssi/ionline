<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estament extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'category',
        'name'
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'cfg_estaments';

    public function professions()
    {
        return $this->hasMany(Profession::class);
    }
    
}
