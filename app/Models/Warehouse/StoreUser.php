<?php

namespace App\Models\Warehouse;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Permission\Models\Role;

class StoreUser extends Pivot
{
    use HasFactory;

    protected $table = 'wre_store_user';

    protected $fillable = [
        'user_id',
        'store_id',
        'role_id',
        'status',
        'is_visator',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isVisator()
    {
        return ($this->is_visator == 1);
    }
}
