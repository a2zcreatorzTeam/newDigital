<?php

namespace App\Providers;

use App\Models\BasicDetail;
use App\Models\Country;
use App\Models\User;
use App\Models\UserPolicyData;
use App\Observers\CnicMobileLinkObserver;
use App\Services\CnicMobileLinkService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CnicMobileLinkService::class);

        $helpers = app_path('Helpers/helpers.php');
        if (is_file($helpers)) {
            require_once $helpers;
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('otp-verify', function (Request $request) {
            return Limit::perMinute(8)->by($request->ip() . '|' . ($request->input('user_id') ?: 'guest'));
        });

        RateLimiter::for('otp-resend', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip() . '|' . ($request->input('user_id') ?: 'guest'));
        });

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

        View::composer([
            'frontend.policyFlow.form.basic_Details',
            'frontend.profile.basic_detail',
            'frontend.self-policy.edit',
            'frontend.partials.life_proposed_fields',
        ], function ($view) {
            if (!$view->offsetExists('countries')) {
                $view->with(
                    'countries',
                    Country::query()->active()->orderBy('name')->get(['id', 'name', 'code'])
                );
            }
        });
    }
}
