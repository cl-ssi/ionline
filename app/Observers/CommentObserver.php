<?php

namespace App\Observers;

use App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource;
use App\Models\Comment;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

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
        // Si el comentario es de un modelo Process entonces enviar una notificación a 
        // todos los usuarios que tengan el permiso 'Agreement: admin'
        if ($comment->commentable_type === 'App\Models\Documents\Agreements\Process') {
    
            $recipients = User::permission('Agreement: admin')
                ->where('establishment_id', $comment->establishment_id)
                ->get();

            Notification::make()
                ->title('Nuevo comentario registrado en proceso ' . $comment->commentable_id)
                ->actions([
                    Action::make('IrAlProceso')
                        ->button()
                        ->url(ProcessResource::getUrl('edit', [$comment->commentable_id]))
                        ->markAsRead(),
                ])
                ->sendToDatabase($recipients);
        } 
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
