<?php

namespace App\Models\Meetings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Commitment extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'description', 'type', 'commitment_user_id', 'commitment_ou_id', 'closing_date', 'meeting_id', 'requirement_id', 'user_id'
    ];

    public function meeting() {
        return $this->belongsTo('App\Models\Meetings\Meeting');
    }

    public function commitmentUser() {
        return $this->belongsTo('App\User', 'commitment_user_id')->withTrashed();
    }

    public function commitmentOrganizationalUnit() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'commitment_ou_id')->withTrashed();
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $cast = [
        'closing_date' => 'date:Y-m-d',
    ];

    protected $table = 'meet_commitments';

}
