<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\FlashMess\FlashMess;
class FlashMessProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //flashmess
        $this->app->singleton('flashmess', function () {
            return new FlashMess();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
