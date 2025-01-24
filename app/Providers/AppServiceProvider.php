<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('frontend.layout', function($view){
            $logo = DB::table('logo')
                        ->limit(1)
                        ->orderByDesc('id') 
                        ->get();
            return $view->with('logo', $logo);
        });
    }
}
