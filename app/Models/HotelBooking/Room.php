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
        'id','hotel_id','room_type_id','identifier','description','max_days_avaliable','single_bed','double_bed','status','price'
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

    public function services()
    {
        return $this->belongsToMany('App\Models\HotelBooking\Service','hb_room_services');
    }

    public function bookingConfigurations()
    {
        return $this->hasMany('App\Models\HotelBooking\RoomBookingConfiguration');
    }

    public function images()
    {
        return $this->hasMany('App\Models\HotelBooking\RoomImage');
    }
}
