<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegalQualityManage extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'name'
    ];

    public function fundamentLegalQuality() {
        return $this->hasMany('App\Models\ReplacementStaff\FundamentLegalQuality');
    }

    public function getNameValueAttribute(){
        switch ($this->name) {
            case 'to hire':
                return 'Contrata';
                break;
            case 'fee':
                return 'Honorarios';
                break;
            case 'holder':
                return 'Titular';
                break;
            case '':
              return '';
              break;
        }
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_legal_quality_manages';
}
