<?php

namespace Blinqpay\PaymentProcessor\Contracts;

interface PaymentGatewayInterface
{
    public function initiatePayment(array $data);

    public function verifyPayment(string $transactionId);
}
