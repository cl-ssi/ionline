<?php

namespace App\Models\HotelBooking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class HotelImage extends Model
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
        'hotel_id'
    ];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'hb_hotel_images';

    public function base64image(){
        $file = base64_encode(Storage::get($this->file));
        return $file;
    }
}
