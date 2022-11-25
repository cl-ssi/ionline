<?php

namespace App\Http\Livewire\Requirements;

use App\Requirements\Requirement;
use Livewire\Component;

class Counters extends Component
{
    public $user;
    public $auth_user;

    public function render()
    {
        return view('livewire.requirements.counters', [
            'counters' => $this->getCounters()
        ]);
    }

    public function getCounters()
    {
        // events copy
        $idEventsCopy = Requirement::eventsCopy($this->user);

        // requirements
        $requirements = Requirement::query();
        $requirements->whereHas('events', function ($query) {
            $query->where('from_user_id', $this->user->id)->orWhere('to_user_id', $this->user->id);
        });

        $requirementsClone = clone $requirements;

        // archived
        $archived = clone $requirements;
        $archived->whereHas('archived', function ($query) {
            $query->whereIn('user_id', [$this->user->id, $this->auth_user->id]);
        });

        // not archived
        $notArchived = clone $requirements;
        $notArchived->whereDoesntHave('archived', function ($query) {
            $query->whereIn('user_id', [$this->user->id, $this->auth_user->id]);
        });

        $counters['total'] = $requirements->count();
        $counters['archived'] = $archived->clone()->whereNotIn('id', $idEventsCopy)->count();
        $counters['pending'] = $notArchived->whereNotIn('id', $idEventsCopy)->count();
        $counters['copy'] = $requirements->whereIn('id', $idEventsCopy)->count();
        $counters['created'] = $requirementsClone->clone()->whereStatus('creado')->whereNotIn('id', $idEventsCopy)->count();
        $counters['replyed'] = $requirementsClone->clone()->whereStatus('respondido')->whereNotIn('id', $idEventsCopy)->count();
        $counters['derived'] = $requirementsClone->clone()->whereStatus('derivado')->whereNotIn('id', $idEventsCopy)->count();
        $counters['closed'] = $requirementsClone->clone()->whereStatus('cerrado')->whereNotIn('id', $idEventsCopy)->count();
        $counters['reopen'] = $requirementsClone->clone()->whereStatus('reabierto')->whereNotIn('id', $idEventsCopy)->count();

        return $counters;
    }
}
