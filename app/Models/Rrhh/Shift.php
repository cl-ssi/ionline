<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\User;

class Shift extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'user_id',
        'year',
        'month',
        'quantity',
        'observation'
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'well_ami_shifts';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
