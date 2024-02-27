<?php

namespace App\Models\Meetings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Grouping extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'type', 'name', 'meeting_id'
    ];

    public function meeting() {
        return $this->belongsTo('App\Models\Meetings\Meeting');
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'meet_groupings';
}
