<?php

namespace App\Providers;

use App\Domain\Businesses\Actions\CreateBusinessAction;
use App\Domain\Businesses\Actions\Interfaces\CreatesBusiness;
use App\Domain\Services\Actions\CreateServiceAction;
use App\Domain\Services\Actions\Interfaces\CreatesService;
use App\Domain\Auth\Actions\RegisterUserAction;
use App\Domain\Auth\Actions\Interfaces\RegistersUser;
use App\Domain\Auth\Actions\LoginUserAction;
use App\Domain\Auth\Actions\Interfaces\LoginUser;
use App\Domain\Businesses\Models\Business;
use App\Domain\Businesses\Policies\BusinessPolicy;
use App\Domain\Services\Models\Service;
use App\Domain\Services\Policies\ServicePolicy;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CreatesBusiness::class,
            CreateBusinessAction::class
        );
        $this->app->bind(
            CreatesService::class,
            CreateServiceAction::class
        );
        $this->app->bind(
            RegistersUser::class,
            RegisterUserAction::class
        );
        $this->app->bind(
            LoginUser::class,
            LoginUserAction::class
        );
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
