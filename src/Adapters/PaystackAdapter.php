<?php

namespace Blinqpay\PaymentProcessor\Adapters;

use Illuminate\Support\Facades\Log;
use Blinqpay\PaymentProcessor\PaymentGateways\Paystack;
use Blinqpay\PaymentProcessor\Contracts\PaymentGatewayInterface;
use Blinqpay\PaymentProcessor\Exceptions\InternalServerException;

class PaystackAdapter implements PaymentGatewayInterface
{
    protected $paystack;

    public function __construct(Paystack $paystack) {
        $this->paystack = $paystack;
    }


    /**
     * @param 
     * @return
     */
    public function initiatePayment(array $data) {
        Log::debug($data);
        return $this->paystack->initiateTransfer($data['amount']);
    }

    public function verifyPayment(string $transactionId): string
    {
        return $this->paystack->verifyTransfer($transactionId);
    }
}
