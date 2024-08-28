<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;

class Subrogation extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'subrogant_id',
        'user_id',
        'level',
        'organizational_unit_id',
        'type',
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'rrhh_subrogations';
    
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
    
    public function subrogant()
    {
        return $this->belongsTo(User::class,'subrogant_id')->withTrashed();
    }
    
    public function organizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }
    
}