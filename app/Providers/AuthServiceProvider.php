<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('access-user', fn (User $user) => $user->isUser());
        Gate::define('access-author', fn (User $user) => $user->isAuthor());
        Gate::define('access-moderator', fn (User $user) => $user->isModerator());
        Gate::define('access-admin', fn (User $user) => $user->isAdmin());
    }
}
