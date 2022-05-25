<?php

namespace App\Providers;

use App\Events\NewMessageDispatched;
use App\Events\NewMessageReplyDispatched;
use App\Listeners\LoginLister;
use App\Listeners\SendMessageNotification;
use Illuminate\Auth\Events\Login;
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
        Login::class =>[
            LoginLister::class,
        ],
        NewMessageDispatched::class => [
           SendMessageNotification::class,
        ],

        NewMessageReplyDispatched::class => [
            SendMessageNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
