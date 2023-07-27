<?php

namespace App\Models\HotelBooking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class RoomService extends Model implements Auditable
{
    use HasFactory;
    // use softDeletes;
    use \OwenIt\Auditing\Auditable;

    //
    protected $fillable = [
        'room_id','service_id'
    ];

    public function rooms()
    {
        return $this->belongsToMany('App\Models\HotelBooking\Room');
    }

    protected $table = 'hb_room_services';
}
