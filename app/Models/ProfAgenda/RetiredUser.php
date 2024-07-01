<?php

namespace App\Models\ProfAgenda;

use App\Models\ProfAgenda\OpenHour;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RetiredUser extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'id','dv','name','fathers_family','mothers_family','email','address','phone_number', 'birthday','active'
    ];

    protected $table = 'prof_agenda_retired_users';

    protected $dates = ['birthday'];

    public function openHours(): HasMany
    {
        return $this->hasMany(OpenHour::class);
    }
}
