<?php

namespace App\Models\Lobby;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'responsible_id',
        'petitioner',
        'date',
        'start_at',
        'end_at',
        'mecanism',
        'subject',
        'exponents',
        'details',
        'status',
        'request_file',
        'acta_file',
        'signature_id',
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table = 'lobby_meetings';

    protected $casts = [
        'start_at' => 'datetime:H:i',
        'end_at' => 'datetime:H:i',
        'status' => 'boolean',
        'date' => 'date',
    ];

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'lobby_meeting_user');
    }

    public function compromises()
    {
        return $this->hasMany(Compromise::class);
    }

    public function scopeFilter($query, $filter)
    {
        foreach ($filter as $type => $value) {
            switch ($type) {
                case 'subject':
                    $query->where('subject', 'LIKE', '%'.$value.'%');
                    break;
                case 'responsible':
                    $array_search = explode(' ', $value);
                    foreach ($array_search as $word) {
                        $query->whereRelation('responsible', function ($q) use ($word) {
                            $q->where('name', 'LIKE', '%'.$word.'%')
                                ->orwhere('fathers_family', 'LIKE', '%'.$word.'%')
                                ->orwhere('mothers_family', 'LIKE', '%'.$word.'%')
                                ->orwhere('id', 'LIKE', '%'.$word.'%');
                        });
                    }
                    break;
                case 'status':
                    $query->where('status', $value);
                    break;
            }
        }
    }
}
