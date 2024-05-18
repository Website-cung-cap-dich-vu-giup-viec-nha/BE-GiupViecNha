<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
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
        Validator::extend('phone_number', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^(0[3|5|7|8|9])+([0-9]{8})$/', $value);
        });

        Validator::replacer('phone_number', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute is not a valid phone number');
        });
    }
}
