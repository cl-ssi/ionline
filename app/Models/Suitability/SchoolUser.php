<?php

namespace App\Models\Suitability;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolUser extends Model
{
    use HasFactory;
    public $table = 'school_users_external';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $fillable = [
        'school_id',
        'user_external_id',
    ];


    public function user() {
        return $this->belongsTo('App\Models\UserExternal','user_external_id');
    }

    public function school() {
        return $this->belongsTo('App\Models\Suitability\School');
    }
}
