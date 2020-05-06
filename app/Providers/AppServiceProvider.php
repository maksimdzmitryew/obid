<?php

namespace App\Providers;

use App\Settings;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    	# longer indexes
    	# MySQL < 5.7.7 and MariaDB < 10.2.2
        Schema::defaultStringLength(191);
        Validator::extend(
            'recaptcha',
            'App\\Validators\\ReCaptcha@validate'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        # Register DuskServiceProvider in the AppServiceProvider class for specific environments:
        # as Dusk is unsafe for production
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
        $this->app->singleton(Settings::class, function() {
            return new Settings();
        });
    }
}
