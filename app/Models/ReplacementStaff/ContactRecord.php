<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ContactRecord extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'replacement_staff_id', 'contact_record_user_id', 'type', 'contact_date', 'observation'
    ];

    public function replacementStaff() {
        return $this->belongsTo('App\Models\ReplacementStaff\ReplacementStaff');
    }

    public function user() {
        return $this->belongsTo('App\User', 'contact_record_user_id')->withTrashed();
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $dates = [
        'contact_date'
    ];

    protected $table = 'rst_contact_records';
}
