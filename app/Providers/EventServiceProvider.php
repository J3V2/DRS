<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Events\DocumentCreated;
use App\Events\DocumentReceived;
use App\Events\DocumentReleased;
use App\Events\DocumentTaggedAsTerminal;
use App\Events\UserLogin;
use App\Events\UserLogout;
use App\Listeners\UserLoginListener;
use App\Listeners\DocumentCreatedListener;
use App\Listeners\DocumentReceivedListener;
use App\Listeners\DocumentReleasedListener;
use App\Listeners\DocumentTaggedAsTerminalListener;
use App\Listeners\UserLogoutListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        DocumentCreated::class => [
            DocumentCreatedListener::class,
        ],
        DocumentReceived::class => [
            DocumentReceivedListener::class,
        ],
        DocumentReleased::class => [
            DocumentReleasedListener::class,
        ],
        DocumentTaggedAsTerminal::class => [
            DocumentTaggedAsTerminalListener::class,
        ],
        UserLogin::class => [
            UserLoginListener::class,
        ],
        UserLogout::class => [
            UserLogoutListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
