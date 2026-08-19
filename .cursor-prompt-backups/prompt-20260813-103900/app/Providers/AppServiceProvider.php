<?php

namespace App\Providers;

use App\Models\BasicDetail;
use App\Models\User;
use App\Models\UserPolicyData;
use App\Observers\CnicMobileLinkObserver;
use App\Services\CnicMobileLinkService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CnicMobileLinkService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $observer = $this->app->make(CnicMobileLinkObserver::class);

        User::saving(function (User $user) use ($observer) {
            $observer->savingUser($user);
        });

        BasicDetail::saving(function (BasicDetail $detail) use ($observer) {
            $observer->savingBasicDetail($detail);
        });

        UserPolicyData::saving(function (UserPolicyData $policy) use ($observer) {
            $observer->savingPolicyData($policy);
        });
    }
}
