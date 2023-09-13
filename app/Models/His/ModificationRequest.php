<?php

namespace App\Models\His;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;

class ModificationRequest extends Model
{
    use HasFactory;

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'his_modification_requests';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'type',
        'subject',
        'body',
    ];
    
    public function creator()
    {
        return $this->belongsTo(User::class,'creator_id')->withTrashed();
    }
}
