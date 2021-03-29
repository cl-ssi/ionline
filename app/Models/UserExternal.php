<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Suitability\Result;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserExternal extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    use Notifiable;

    public $table = 'users_external';

    protected $guard = 'external';

    protected $fillable = [
        'id',
        'name', 'email', 'password',
        'dv', 'fathers_family', 'mothers_family',
        'position','gender',
        'address','phone_number',
        'school_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function runFormat() {
        return number_format($this->id, 0,'.','.') . '-' . $this->dv;
    }

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->fathers_family} {$this->mothers_family}";
    }

    public function userResults()
    {
        return $this->hasMany(Result::class, 'user_id', 'id');
        //return $this->hasMany('App\Models\Result', 'user_id', 'id');
    }
}
