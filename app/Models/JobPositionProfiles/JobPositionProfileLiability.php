<?php

namespace App\Models\JobPositionProfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class JobPositionProfileLiability extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'value' 
    ];

    public function liability() {
        return $this->belongsTo('App\Models\JobPositionProfiles\Liability', 'liability_id');
    }

    public function getYesNoValueAttribute() {
        switch($this->value) {
          case '0':
            return 'No';
            break;
          case '1':
            return 'Sí';
            break;
        }
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

     protected $hidden = [
        'created_at', 'updated_at'
    ];

    // protected $dates = [
    //     ''
    // ];

    // protected $casts = [
    //     'degree' => 'integer'
    // ];

    protected $table = 'jpp_profile_liabilities';
}
