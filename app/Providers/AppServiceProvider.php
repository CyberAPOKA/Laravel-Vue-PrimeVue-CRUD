<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Validator;

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
        User::observe(UserObserver::class);

        Validator::extend('cpf_unique', function ($attribute, $value, $parameters, $validator) {
      
            $cpf = str_replace(['.', '-'], '', $value);

            return !User::where('cpf', $cpf)->where('id', '<>', $parameters[0])->exists();
        });
    }
}
