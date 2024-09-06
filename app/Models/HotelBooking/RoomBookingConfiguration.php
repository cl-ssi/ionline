<?php

namespace App\Models\HotelBooking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class RoomBookingConfiguration extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hb_room_booking_configurations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'room_id',
        'start_date',
        'end_date',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'price',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',

        'monday' => 'boolean',
        'tuesday' => 'boolean',
        'wednesday' => 'boolean',
        'thursday' => 'boolean',
        'friday' => 'boolean',
        'saturday' => 'boolean',
        'sunday' => 'boolean'
    ];

    /**
     * Get the room that owns the booking configuration.
     *
     * @return BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Generate an array of active days for the booking configuration.
     *
     * @return array
     */
    public function day_array(): array
    {
        $array = [];
        if ($this->monday) {
            $array[1] = 1;
        }
        if ($this->tuesday) {
            $array[2] = 1;
        }
        if ($this->wednesday) {
            $array[3] = 1;
        }
        if ($this->thursday) {
            $array[4] = 1;
        }
        if ($this->friday) {
            $array[5] = 1;
        }
        if ($this->saturday) {
            $array[6] = 1;
        }
        if ($this->sunday) {
            $array[7] = 1;
        }
        return $array;
    }
}
