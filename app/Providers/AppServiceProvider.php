<?php

namespace App\Providers;

use App\Domain\Services\Models\Service;
use App\Domain\Services\Policies\ServicePolicy;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Domain\Businesses\Models\Business;
use App\Domain\Businesses\Policies\BusinessPolicy;

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
        JsonResource::withoutWrapping();
        Gate::policy(Business::class,BusinessPolicy::class);
        Gate::policy(Service::class,ServicePolicy::class);
    }
}
