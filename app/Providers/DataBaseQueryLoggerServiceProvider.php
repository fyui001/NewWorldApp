<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\ServiceProvider;

class DataBaseQueryLoggerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment("local")) {
            \DB::listen(function ($query) {
                $route = 'NOT URL';
                if (method_exists(new \Request(), 'getName')) {
                    $route = \Request::route()->getName();
                }
                $sql = $query->sql;
                foreach ($query->bindings as $binding) {
                    if (is_string($binding)) {
                        $binding = "'{$binding}'";
                    } elseif (is_bool($binding)) {
                        $binding = $binding ? '1' : '0';
                    } elseif (is_int($binding)) {
                        $binding = (string) $binding;
                    } elseif ($binding === null) {
                        $binding = 'NULL';
                    } elseif ($binding instanceof Carbon) {
                        $binding = "'{$binding->toDateTimeString()}'";
                    } elseif ($binding instanceof DateTime) {
                        $binding = "'{$binding->format('Y-m-d H:i:s')}'";
                    }
                    $sql = preg_replace('/\\?/', (string)$binding, $sql, 1);
                }
                \Log::info($sql);
                \Log::channel('sql')->info('[ROUTE]' . $route );
                \Log::channel('sql')->info('[QUERY]' . $sql);
                \Log::channel('sql')->info('[TIME]' . "time(ms):{$query->time}" . PHP_EOL);
            });
        }
    }
}
