<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'user_id'
    ];

    public function organizationalUnit() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_commissions';
}
