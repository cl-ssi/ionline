<?php

namespace App\Models\HotelBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class RoomBookingFile extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'file',
        'name',
        'room_booking_id'
    ];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'hb_room_booking_files';

}
