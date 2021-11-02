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
        'name', 'profile_manage_id'
    ];

    public function profileManage() {
        return $this->belongsTo('App\Models\ReplacementStaff\ProfileManage');
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_profession_manages';
}
