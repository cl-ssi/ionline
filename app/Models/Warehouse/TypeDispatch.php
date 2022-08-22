<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeDispatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'wre_type_dispatches';

    protected $fillable = [
        'name',
        'active',
    ];

    public static function internal()
    {
        return 1;
    }

    public static function adjustInventory()
    {
        return 2;
    }

    public static function sendToStore()
    {
        return 3;
    }

    public static function external()
    {
        return 4;
    }
}
