<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
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
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->fathers_family} {$this->mothers_family}";
    }
}
