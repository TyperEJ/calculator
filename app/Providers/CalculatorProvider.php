<?php

namespace App\Providers;

use App\Services\Calculator;
use App\Services\InterfaceCalculator;
use Illuminate\Support\ServiceProvider;

class CalculatorProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(InterfaceCalculator::class, function () {
            return new Calculator();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
