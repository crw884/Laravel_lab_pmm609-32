<?php

namespace App\Providers;

use App\Models\Group;
use App\Models\Post;
use App\Models\User;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Paginator::defaultView('pagination::default');

        Gate::define('destroy-post', function (User $user, Post $post) {
            $group = Group::all()->where('id', $post->group_id)->first();
           return $user->id === $post->user_id OR $group->admin_id === $user->id;
        });

        Gate::define('create-post', function (User $user, Group $group) {
            return $user->groups()->where('group_id', $group->id)->exists()
                OR $user->id === $group->admin_id;
        });

        Gate::define('editOrDestroyGroup', function (User $user, Group $group) {
            return $user->id === $group->admin()->id;
        });
    }
}
