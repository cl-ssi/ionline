<?php

namespace App\Models\Inv;

use App\Models\Establishment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Permission\Models\Role;

class EstablishmentUser extends Pivot
{
    use HasFactory;
    
    protected $table = 'inv_establishment_user';

    protected $fillable = [
        'establishment_id',
        'role_id',
        'user_id',
    ];

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
