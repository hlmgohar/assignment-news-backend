<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    { 
        // This will run every time a request is made to your Laravel app
        $this->runMyFunction();
    }

    public function register()
    {
        //
    }

    public function runMyFunction()
    {
        // Your function logic here
        \Log::info('This function runs every time the app is loaded.');
    }
}
