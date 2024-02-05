<?php

namespace Blinqpay\PaymentProcessor\Adapters;

use Blinqpay\PaymentProcessor\PaymentGateways\Flutterwave;
use Blinqpay\PaymentProcessor\Contracts\PaymentGatewayInterface;

class FlutterwaveAdapter implements PaymentGatewayInterface
{
    private $flutterwave;

    public function __construct(Flutterwave $flutterwave) {
        $this->flutterwave = $flutterwave;
    }

    /**
     * @param 
     * @return
     */
    public function initiatePayment(array $payload) {
        return $this->flutterwave->initiateTransfer(
            $payload['amount'], 
            $payload['email'], 
            $payload['currency'], 
            $payload['reference']
        );
    }

    public function verifyPayment(string $transactionId): string
    {
        return $this->flutterwave->verifyTransfer($transactionId);
    }
}
