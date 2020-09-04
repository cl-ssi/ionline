<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Ticket\Ticket;
use App\Rrhh\Authority;
use App\RequestForms\RequestForm;
use App\RequestForms\RequestFormEvent;
use Carbon\Carbon;

class Utilities extends Model
{
    public static function getPendingTickets()
    {
        /*$pendingTickets = Ticket::where('assigned_id',Auth::id())
                                ->whereIn('status', ['pending','assigned'])->count();
        if($pendingTickets > 0) {
            return $pendingTickets;
        }*/
    }

    public static function getPendingSignature()
    {
        // $pendingRF = RequestForm::where('whorequest_id',Auth::id())->whereIn('status', ['new'])->count();
        // if($pendingRF > 0) {
        //     return $pendingRF;
        // }
    }

    public static function getPendingSignatureAuthorize()
    {
        // $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);
        // $label = array();
        // foreach ($authorities as $key => $authority) {
        //   $label['uo_id'] = $authority->organizational_unit_id;
        // }
        // $countPendingRF = RequestForm::all()->where('status', 'approved_petitioner')->whereIn('whoauthorize_unit_id', $label)->count();
        //
        // if($countPendingRF > 0) {
        //     return $countPendingRF;
        // }
    }

    public static function getPermissionSignaureAuthorize()
    {
        $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);
        $label = array();
        foreach ($authorities as $key => $authority) {
          $label['uo_id'] = $authority->organizational_unit_id;
        }
        return $label;
    }

    public static function getPendingFinance()
    {
        // $countPendingRF = RequestForm::all()->where('status', 'approved_chief')->count();
        //
        // if($countPendingRF > 0) {
        //     return $countPendingRF;
        // }
        // else {
        //   return 'cero';
        // }
    }

    public static function getAmIDirector()
    {
        $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);
        foreach ($authorities as $key => $authority) {
            if($authority->organizational_unit_id == 1){
              return $authority->organizational_unit_id;
            }
        }
    }
    public static function getPendingDirectorAuthorize()
    {
        $rfs = RequestForm::whereDoesntHave('requestformevents', function (Builder $query) {
                  $query->where('type', 'director');
              })->where('type_form', 'passage')->count();

        if($rfs> 0) {
            return $rfs;
        }
        else {
            return null;
        }
    }
}
