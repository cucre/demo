<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider {
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
    public function boot() {
        \Validator::extend('unique_unsensitive', function ($attribute, $value, $parameters, $validator) {
            $query = DB::table($parameters[0])
                        ->where($parameters[1], 'LIKE', '%'. $value .'%')
                        ->whereNull('deleted_at');

            if(isset($parameters[2])) {
                $query = $query->where($parameters[1], '!=', $parameters[2]);
            }

            $query = $query->get();

            return $query->count() == 0;
        });

        Carbon::setLocale('es');
        Carbon::setUTF8(true);
        setlocale(LC_TIME, 'es_ES');
        Schema::defaultStringLength(191);
    }
}