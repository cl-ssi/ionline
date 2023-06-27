<?php

namespace App\Models\HotelBooking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Room extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    //
    protected $fillable = [
        'id','hotel_id','room_type_id','identifier','description'
    ];

    protected $table = 'hb_rooms';

    // relaciones
    public function hotel()
    {
        return $this->belongsTo('App\Models\HotelBooking\Hotel');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\HotelBooking\RoomType','room_type_id');
    }
}
