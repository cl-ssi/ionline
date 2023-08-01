<?php

namespace App\Models\HotelBooking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

use Carbon\CarbonPeriod;

class RoomBooking extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    //
    protected $fillable = [
        'id','user_id','room_id','start_date','end_date','observation','payment_type'
    ];

    protected $table = 'hb_room_bookings';

    protected $dates = ['start_date','end_date'];

    // relaciones
    public function room()
    {
        return $this->belongsTo('App\Models\HotelBooking\Room');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function day_array(){
        $array = [];
        $diff = $this->start_date->diffInDays($this->end_date);
        if($this->start_date == $this->end_date){
            $array[$this->start_date->format('Y-m-d')] = "M";
        }else{
            foreach (CarbonPeriod::create($this->start_date, '1 day', $this->end_date) as $position => $day) {
                $array[$day->format('Y-m-d')] = "M";
                if($position==0){$array[$day->format('Y-m-d')] = "I";}
                if($position==$diff){$array[$day->format('Y-m-d')] = "T";}
            }
        }
        // dd($array);
        return $array;
    }

    public function files()
    {
        return $this->hasMany('App\Models\HotelBooking\RoomBookingFile');
    }
}
