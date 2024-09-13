<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
   
    protected $middlewareGroups = [
       

        'api' => [
            // Sanctum Middleware (for API token auth)
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    protected $commands = [
        \App\Console\Commands\FetchNewsArticles::class,
        \App\Console\Commands\FetchBbcNewsArticles::class,,
        \App\Console\Commands\SearchSportsArticles::class,
    ];
    
    protected function schedule(Schedule $schedule)
    {
        // Schedule the command to run periodically (e.g., daily)
        $schedule->command('fetch:news-articles')->daily();
        // Schedule the command to run periodically (e.g., daily)
        $schedule->command('fetch:bbc-news-articles')->daily();

        $schedule->command('articles:search-sportss')->daily();

    }
    
}
