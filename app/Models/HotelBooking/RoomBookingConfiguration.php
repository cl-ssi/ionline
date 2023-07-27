<?php

namespace App\Models\HotelBooking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class RoomBookingConfiguration extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    //
    protected $fillable = [
        'id','room_id','start_date','end_date','monday','tuesday','wednesday','thursday','friday','saturday','sunday','price','status'
    ];

    public function room()
    {
        return $this->belongsTo('App\Models\HotelBooking\Room');
    }

    public function day_array(){
        $array = [];
        if($this->monday){$array[1] = 1;}
        if($this->tuesday){$array[2] = 1;}
        if($this->wednesday){$array[3] = 1;}
        if($this->thursday){$array[4] = 1;}
        if($this->friday){$array[5] = 1;}
        if($this->saturday){$array[6] = 1;}
        if($this->sunday){$array[7] = 1;}
        return $array;
    }

    protected $table = 'hb_room_booking_configurations';

    protected $dates = ['start_date','end_date'];
}
