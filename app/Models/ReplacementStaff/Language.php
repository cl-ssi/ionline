<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'language', 'level', 'file', 'replacement_staff_id'
    ];

    public function replacement_staff() {
        return $this->belongsTo('App\Models\ReplacementStaff\ReplacementStaff');
    }

    public function getLanguageValueAttribute(){
        switch ($this->language) {
            case 'english':
              return 'Inglés';
              break;
            case 'french':
              return 'Francés';
              break;
            case 'german':
              return 'Alemán';
              break;
            default:
              return '';
              break;
        }
    }

    public function getLevelValueAttribute(){
        switch ($this->level) {
            case 'basic':
              return 'Básico';
              break;
            case 'intermediate':
              return 'Intermedio';
              break;
            case 'advanced':
              return 'Avanzado';
              break;
            default:
              return '';
              break;
        }
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_languages';
}
