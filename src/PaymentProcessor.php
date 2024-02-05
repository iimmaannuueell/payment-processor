<?php

namespace Blinqpay\PaymentProcessor;

use Blinqpay\PaymentProcessor\Models\Gateway;
use Blinqpay\PaymentProcessor\Models\LogActivity;   
use Blinqpay\PaymentProcessor\Models\ProcessorConfig;

class PaymentProcessor
{
    protected $paymentGateway;
    protected $logService;

    public function __construct() 
    {}
    


    public static function processPayment($data) {
        $selectedPaymentGateway = self::dynamicRouter($data);
    
        self::logActivities([
            'amount' => $data['amount'],
            'reference' => $data['reference'],
            'email' => $data['email'],
            'currency' => $data['currency'],
            'provider' => 'nill'
        ]);
        return $selectedPaymentGateway->initiatePayment($data);
    }

    protected static function isGatewayEnabled($gateway) {
        $gateway = Gateway::where('name', $gateway)->first();
        if(!$gateway) {
            return false; 
        }
        return true;
    }

    protected static function dynamicRouter(array $data) {
        $availableGateways = ProcessorConfig::all();
        $defaultGateway = ProcessorConfig::where('conditions', 'default')->first();
    
        $selectedPaymentGateway = null;
    
        foreach ($availableGateways as $gatewayConfig) {

            $conditionMethod = 'self::'.$gatewayConfig->conditions;
                if (call_user_func($conditionMethod, $data)) {
                    if (self::isGatewayEnabled($gatewayConfig->gateway_provider)) {
                        $selectedPaymentGateway = app()->make($gatewayConfig['adapter']);
                    }
                    break 1;
                }
        }

        if (!$selectedPaymentGateway) {
            $defaultGatewayId = config('payment.default_gateway');
            if (self::isGatewayEnabled($defaultGatewayId)) {
                $selectedPaymentGateway = app()->make($availableGateways->adapter);
            } else {
                $selectedPaymentGateway = app()->make($defaultGateway->adapter);
            }
        }
    
        return $selectedPaymentGateway;
    }

    protected static function currencyUSD($data) {
        if($data['currency'] == 'USD') {
            return true;
        }
        return false;
    }
    
    protected static function thresholdAmount($data) {
        if($data['amount'] == 2000) {
            return true;
        }
        return false;
    }

    protected static function default() {
        return true;
    }

    protected static function logActivities(array $data)
    {
        LogActivity::create([
            'reference' => $data['reference'],
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'status' => $data['status'] ?? 'pending',
            'email' => $data['email'],
            'gateway_provider' => $data['provider'],
        ]);
    }

}