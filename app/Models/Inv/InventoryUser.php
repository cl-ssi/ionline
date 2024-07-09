<?php

namespace App\Models\Inv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class InventoryUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inv_inventory_user';

    protected $fillable = [
        'inventory_id',
        'user_id',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

}
