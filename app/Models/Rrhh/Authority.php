<?php

namespace App\Models\Rrhh;

use App\Enums\Rrhh\AuthorityType;
use App\Models\Agreements\Agreement;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Authority extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    const TYPE_MANAGER = 'manager';
    const TYPE_SECRETARY = 'secretary';
    const TYPE_DELEGATE = 'delegate';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rrhh_authorities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'organizational_unit_id',
        'date',
        'position',
        'type',
        'decree',
        'from_time',
        'to_time',
        'representation_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date:Y-m-d',
        'type' => AuthorityType::class,
    ];

    /**
     * Get the organizational unit that owns the authority.
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    /**
     * Get the user that owns the authority.
     */
    public function user(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    // TODO: @tebiccr esto se usa?
    /**
     * Get the creator of the authority.
     */
    public function creator(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class, 'creator_id')->withTrashed();
    }

    /**
     * Get the user that the authority represents.
     */
    public function representation(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class, 'representation_id')->withTrashed();
    }

    /**
     * Get the agreements for the authority.
     */
    public function agreement(): HasMany
    {
        return $this->hasMany(Agreement::class);
    }

    /**
     * Get the authority from a specific date.
     *
     * @param int $ou_id
     * @param \Carbon\Carbon $date
     * @param string $type
     * @return \App\Models\Rrhh\Authority|null
     */
    public static function getAuthorityFromDate($ou_id, $date, $type)
    {
        return self::with('user', 'organizationalUnit')
            ->where('organizational_unit_id', $ou_id)
            ->where('date', $date->toDateString())
            ->where('type', $type)
            ->first();

    }

    /**
     * Get today's authority manager from a specific date.
     *
     * @param int $ou_id
     * @return \App\Models\Rrhh\Authority|null
     */
    public static function getTodayAuthorityManagerFromDate($ou_id)
    {
        return self::getAuthorityFromDate($ou_id, today(), 'manager');
    }

    public static function getAuthorityFromAllTime($ou_id, $type)
    {

        return self::with('user', 'organizationalUnit')
            ->where('organizational_unit_id', $ou_id)
            ->where('type', $type)
            ->groupBy('user_id')
            ->get();
    }

    public static function getBossFromUser($user_id, $date)
    {
        $user = User::find($user_id);
        if ($user) {
            return self::getAuthorityFromDate($user->organizational_unit_id, $date, 'manager');
        }
    }

    public static function getAmIAuthorityFromOu($date, $type, $user_id)
    {
        $query = self::with('user', 'organizationalUnit')
            ->where('user_id', $user_id)
            ->where('date', $date->toDateString());

        if (is_array($type)) {
            $query->whereIn('type', $type);
        } else {
            $query->where('type', $type);
        }

        return $query->get();
    }

    public static function getAmIAuthorityOfMyOu($date, $type, $user_id)
    {
        $user = User::find($user_id);

        if ($user and $user->organizational_unit_id != null) {
            return self::with('user', 'organizationalUnit')
                ->where('user_id', $user_id)
                ->where('date', $date->toDateString())
                ->where('type', $type)
                ->where('organizational_unit_id', $user->organizational_unit_id)
                ->exists();
        } else {
            return false;
        }
    }
}
