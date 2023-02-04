<?php

namespace App\Models\JobPositionProfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class JobPositionProfileSign extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'position', 'event_type', 'status', 'observation', 'date_sign'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'jpp_job_position_profile_signs';
}
