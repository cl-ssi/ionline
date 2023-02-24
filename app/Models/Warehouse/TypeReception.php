<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeReception extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'wre_type_receptions';

    protected $fillable = [
        'name',
        'active',
    ];

    public static function receiving()
    {
        return 1;
    }

    public static function receiveFromStore()
    {
        return 2;
    }

    public static function return()
    {
        return 3;
    }

    public static function purchaseOrder()
    {
        return 4;
    }

    public static function adjustInventory()
    {
        return 5;
    }
}
