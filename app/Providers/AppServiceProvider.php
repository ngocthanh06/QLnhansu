<?php

namespace App\Providers;
use App\Repositories\TodoInterfaceWork\AccountReponsitory;
use App\Repositories\TodoInterfaceWork\AttendanceReponsitories1;
use App\Repositories\TodoInterfaceWork\AttendanceReponsitory;
use App\Repositories\TodoInterfaceWork\ContractReponsitory;
use App\Repositories\TodoInterfaceWork\JoinModelReponsitory;
use App\Repositories\TodoInterfaceWork\PermissionReponsitory;
use App\Repositories\TodoInterfaceWork\SupportInterface;
use App\Repositories\Work\AcceptSalaryEloquent;
use App\Repositories\Work\AccountEloquent;
use App\Repositories\Work\AttendanceEloquent;
use App\Repositories\Work\AttendanceEloquent1;
use App\Repositories\Work\ContractEloquent;
use App\Repositories\Work\HellperEloquent;
use App\Repositories\Work\JoinModelEloquent;
use App\Repositories\Work\PermissionEloquent;
use App\Repositories\Work\SupportEloquent;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Helper\HelperInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(AccountReponsitory::class, AcceptSalaryEloquent::class);
        $this->app->singleton(AccountReponsitory::class, AccountEloquent::class);
        $this->app->singleton(ContractReponsitory::class, ContractEloquent::class);
        $this->app->singleton(PermissionReponsitory::class, PermissionEloquent::class);
        $this->app->singleton(AttendanceReponsitory::class, AttendanceEloquent::class);
        $this->app->singleton(SupportInterface::class, SupportEloquent::class);
        $this->app->singleton(JoinModelReponsitory::class, JoinModelEloquent::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }
}
