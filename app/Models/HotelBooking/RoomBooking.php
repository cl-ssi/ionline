<?php

namespace App\Models\HotelBooking;

use App\Models\HotelBooking\Room;
use App\Models\HotelBooking\RoomBookingFile;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class RoomBooking extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hb_room_bookings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'room_id',
        'start_date',
        'end_date',
        'payment_type',
        'status',
        'cancelation_observation',
        'observation',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /**
     * Get the room that owns the booking.
     *
     * @return BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the user that owns the booking.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the files associated with the booking.
     *
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(RoomBookingFile::class);
    }

    /**
     * Generate an array of days for the booking period.
     *
     * @return array
     */
    public function day_array(): array
    {
        $array = [];
        $diff = (int) $this->start_date->diffInDays($this->end_date);
        if ($this->start_date == $this->end_date) {
            $array[$this->start_date->format('Y-m-d')] = "M";
        } else {
            foreach (CarbonPeriod::create($this->start_date, '1 day', $this->end_date) as $position => $day) {
                $array[$day->format('Y-m-d')] = "M";
                if ($position == 0) {
                    $array[$day->format('Y-m-d')] = "I";
                }
                if ($position == $diff) {
                    $array[$day->format('Y-m-d')] = "T";
                }
            }
        }
        return $array;
    }
}
