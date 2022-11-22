<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/* TODO: Eliminar cuando se mueva el modelo User a App\Models */
use App\User;

class AccessLog extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'user_id',
        'type',
        'switch_id',
        'enviroment'
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'cfg_access_logs';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function switchUser()
    {
        return $this->belongsTo(User::class, 'switch_id');
    }
    
}
