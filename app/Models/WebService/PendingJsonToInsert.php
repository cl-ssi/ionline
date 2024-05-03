<?php

namespace App\Models\WebService;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingJsonToInsert extends Model
{
    use HasFactory;

    protected $table = 'ws_pending_json_to_insert';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'model_route',
        'data_json',
        'column_mapping',
        'primary_keys',
        'procesed',
    ];
}
