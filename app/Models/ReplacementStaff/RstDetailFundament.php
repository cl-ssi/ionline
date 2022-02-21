<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RstDetailFundament extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'fundament_detail_id', 'fundament_manage_id'
    ];

    public function fundamentDetailManage() {
        return $this->belongsTo('App\Models\ReplacementStaff\FundamentDetailManage', 'fundament_detail_id');
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_detail_fundaments';
}
