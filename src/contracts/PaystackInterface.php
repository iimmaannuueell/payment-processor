<?php

namespace Blinqpay\PaymentProcessor\Contracts;

interface PaystackInterface
{
    public function initiateTransfer(float|int $amount);

    public function verifyTransfer(string $transactionId): string;
}