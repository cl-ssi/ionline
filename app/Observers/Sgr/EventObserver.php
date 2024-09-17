<?php

namespace App\Observers\Sgr;

use App\Models\Sgr\Event;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     */
    public function creating(Event $event): void
    {
        $event->creator_id = auth()->id();
        $event->creator_ou_id = auth()->user()->organizational_unit_id;
        $event->event_type_id = $event->requirement->event_type_id;
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "restored" event.
     */
    public function restored(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "force deleted" event.
     */
    public function forceDeleted(Event $event): void
    {
        //
    }
}
