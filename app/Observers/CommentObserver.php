<?php

namespace App\Observers;

use App\Models\Comment;

class CommentObserver
{
    /**
     * Handle the Comment "creating" event.
     */
    public function creating(Comment $comment): void
    {
        //set user, organizationalUnit y establishment
        $comment->author_id = auth()->id();
        $comment->organizational_unit_id = auth()->user()->organizationalUnit->id;
        $comment->establishment_id = auth()->user()->establishment->id;
    }

    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "updated" event.
     */
    public function updated(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "restored" event.
     */
    public function restored(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "force deleted" event.
     */
    public function forceDeleted(Comment $comment): void
    {
        //
    }
}
