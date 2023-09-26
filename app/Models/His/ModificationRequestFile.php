<?php

namespace App\Models\His;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\His\ModificationRequest;

class ModificationRequestFile extends Model
{
    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'his_modification_request_files';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'file',
        'name',
        'request_id',
    ];
    
    public function request()
    {
        return $this->belongsTo(ModificationRequest::class,'request_id');
    }
}
