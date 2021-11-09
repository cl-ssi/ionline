<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundamentLegalQuality extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'fundament_manage_id', 'legal_quality_manage_id'
    ];

    public function rstFundamentManage() {
        return $this->belongsTo('App\Models\ReplacementStaff\RstFundamentManage', 'fundament_manage_id');
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_fundament_legal_quality';
}
