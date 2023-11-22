<?php

namespace App\Models\TextTemplates;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class TextTemplate extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'title', 
        'module',
        'input',
        'template',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }
}
