<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Documents\Approval;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Rrhh\NewPerformanceReport;

class PerformanceReport extends Model
{
    use HasFactory;
    use SoftDeletes;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rrhh_performance_reports';


    protected $fillable = [
        'period_id',
        'cantidad_de_trabajo',
        'calidad_del_trabajo',
        'conocimiento_del_trabajo',
        'interes_por_el_trabajo',
        'capacidad_trabajo_en_grupo',
        'asistencia',
        'puntualidad',
        'cumplimiento_normas_e_instrucciones',
        'creator_user_observation',
        'received_user_observation',
        'created_user_id',
        'created_ou_id',
        'received_user_id',
        'received_ou_id',
    ];

    protected $casts = [
      
    ];

    public function period()
    {
        return $this->belongsTo(PerformanceReportPeriod::class, 'period_id');
    }

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function createdOrganizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class, 'created_ou_id');
    }

    public function receivedUser()
    {
        return $this->belongsTo(User::class, 'received_user_id');
    }

    public function receivedOrganizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class, 'received_ou_id');
    }

    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function mail($users)
    {
        Notification::route('mail', $users)->notify(new NewPerformanceReport($this));
    }

    public function allApprovalsOk(): bool
    {
        $approvals = $this->approvals;
        
        return $approvals->every(function ($approval) {
            return $approval->status == 1;
        });
    }




}
