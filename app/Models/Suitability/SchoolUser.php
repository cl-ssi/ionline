<?php

namespace App\Models\Suitability;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolUser extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $fillable = [
        'school_id',
        'user_id',        
    ];


    public function user() {
        return $this->belongsTo('App\User');
    }

    public function school() {
        return $this->belongsTo('App\Models\Suitability\School');
    }
}
