<?php

namespace App\Observers\Parameters;

use App\Models\Parameters\News;
use Illuminate\Support\Facades\Storage;

class NewsObserver
{
    /**
     * Handle the News "created" event.
     */
    public function created(News $news): void
    {
        //
    }

    /**
     * Handle the News "updated" event.
     */
    public function updated(News $news): void
    {
        if ($news->isDirty('image')) {
            $originalPath = $news->getOriginal('image');
            if (Storage::exists($originalPath)) {
                Storage::delete($originalPath);
            }
        }
    }

    /**
     * Handle the News "deleted" event.
     */
    public function deleted(News $news): void
    {
        if (Storage::exists($news->image)) {
            Storage::delete($news->image);
        }
    }

    /**
     * Handle the News "restored" event.
     */
    public function restored(News $news): void
    {
        //
    }

    /**
     * Handle the News "force deleted" event.
     */
    public function forceDeleted(News $news): void
    {
        //
    }
}
