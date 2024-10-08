<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\EventPolicy;
use App\Policies\TicketPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        JsonResource::withoutWrapping();
        Gate::define('delete-event', function (User $user, Event $event) {
            return $user->id === $event->organizer_id;
        });
        Gate::policy(Event::class, EventPolicy::class);
        Gate::policy(Ticket::class, TicketPolicy::class);
        Model::preventLazyLoading();
    }
}
