<?php

namespace App\Providers;

use App\Models\Inv\InventoryLabel;
use App\Models\Pharmacies\PurchaseItem;
use App\Models\Pharmacies\ReceivingItem;
use App\Models\Pharmacies\DispatchItem;
use App\Observers\PurchaseItemObserver;
use App\Observers\ReceivingItemObserver;
use App\Observers\DispatchItemObserver;
use App\Observers\InventoryLabelObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //observers
        PurchaseItem::observe(PurchaseItemObserver::class);
        ReceivingItem::observe(ReceivingItemObserver::class);
        DispatchItem::observe(DispatchItemObserver::class);
        InventoryLabel::observe(InventoryLabelObserver::class);
    }
}
