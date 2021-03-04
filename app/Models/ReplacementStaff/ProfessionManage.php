<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfessionManage extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'name'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public function getNameAttribute()
    {
        return ucwords(strtolower($this->attributes['name']));
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_profession_manages';
}
