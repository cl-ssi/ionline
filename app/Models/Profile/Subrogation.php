<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Subrogation extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'subrogant_id','user_id','level'
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'rrhh_subrogations';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function subrogant()
    {
        return $this->belongsTo(User::class,'subrogant_id');
    }
    
}