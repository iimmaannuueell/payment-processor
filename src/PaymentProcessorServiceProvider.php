<?php

namespace Blinqpay\PaymentProcessor;

use Illuminate\Support\ServiceProvider;
use Blinqpay\PaymentProcessor\PaymentProcessor;

class PaymentProcessorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/paymentProcessor.php' => config_path('paymentProcessor.php')
        ]);

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'courier-migrations');
    }

    public function register()
    {
        $this->app->singleton(PaymentProcessor::class, function () {
            return new PaymentProcessor();
        });
    }
}