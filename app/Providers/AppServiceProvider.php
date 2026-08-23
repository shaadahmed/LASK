<?php

namespace App\Providers;

use App\Checks\ActiveDatabaseConnectionsCheck;
use App\Checks\ApplicationEnvironmentCheck;
use App\Checks\CacheStoreCheck;
use App\Checks\DatabaseSizeCheck;
use App\Checks\OptimizationCheck;
use App\Checks\TableSizesCheck;
use App\Listeners\LogAuthEvents;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Facades\Health;

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
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        Event::listen(Login::class, LogAuthEvents::class);
        Event::listen(Logout::class, LogAuthEvents::class);
        Event::listen(Failed::class, LogAuthEvents::class);

        Health::checks([
            DatabaseCheck::new()->label('MySQL Database'),
            DatabaseSizeCheck::new()->label('MySQL Database Size'),
            TableSizesCheck::new()->label('MySQL Table Sizes'),
            ActiveDatabaseConnectionsCheck::new()->label('Currently Active Connections'),
            CacheStoreCheck::new()->label('Laravel Cache'),
            ApplicationEnvironmentCheck::new()->label('Laravel Environment'),
            DebugModeCheck::new()
                ->label('Laravel Debug Mode')
                ->expectedToBe(app()->environment(['local', 'development'])),
            OptimizationCheck::new()->label('Laravel Optimization'),
        ]);
    }
}
