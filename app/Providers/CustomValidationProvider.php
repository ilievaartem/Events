<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class CustomValidationProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Validator::extend('custom_event_path', function ($attribute, $value, $parameters, $validator) {

            $pattern = "/^\/events\/[a-f0-9\-]+\/photos\/[a-zA-Z0-9]+\.(jpg|jpeg|png)$/";

            return preg_match($pattern, $value);
        });

    }
}
