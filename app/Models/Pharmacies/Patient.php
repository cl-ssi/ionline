<?php

namespace App\Models\Pharmacies;

use App\Models\Establishment;
use App\Models\Pharmacies\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frm_patients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'dv',
        'full_name',
        'phone',
        'observation',
        'address',
        'establishment_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public static function getUsersBySearch($searchText)
    {
        $users = Patient::query()->withTrashed();
        if ($searchText) {
            $array_search = explode(' ', $searchText);
            foreach ($array_search as $word) {
                $users->where(function ($q) use ($word) {
                    $q->where('full_name', 'LIKE', '%'.$word.'%')
                        // ->orwhere('fathers_family', 'LIKE', '%'.$word.'%')
                        // ->orwhere('mothers_family', 'LIKE', '%'.$word.'%')
                        ->orwhere('id', 'LIKE', '%'.$word.'%');
                        // ->orwhere('dv','LIKE', '%'.$word.'%');
                });
            }
        }

        return $users;
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }
}
