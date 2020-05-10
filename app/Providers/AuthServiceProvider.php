<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\ProductReview;
use App\Policies\ProductPolicy;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Product::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /* define a admin user role */
        Gate::define('isAdmin', function (User $user) {
            return $user->role === User::ROLE_ADMIN;
        });
        /* define a manager user role */
        Gate::define('isManager', function (User $user) {
            return $user->role === User::ROLE_MANGER;
        });
        /* define a content_editor  user role */
        Gate::define('isGeneral', function (User $user) {
            return $user->role === User::ROLE_USER;
        });
        /* define a user role */
        Gate::define('isUser', function (User $user) {
            return $user->role === 'user';
        });

        Gate::define('product_update', function (User $user, ProductReview $review) {
            return $user->role === User::ROLE_ADMIN && $user->id === $review->user_id;
        });

    }
}
