<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class News extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'type', 'title', 'subtitle', 'image', 'lead', 'body', 'publication_date_at', 'until_at', 'publication_date_at', 'user_id'
    ];

    public function user() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

     protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'created_at'            => 'datetime',
        'publication_date_at'   => 'datetime',
        'until_at'              => 'datetime',
    ];

    protected $table = 'news';
}
