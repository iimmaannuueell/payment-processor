<?php

namespace Blinqpay\PaymentProcessor\Contracts;

interface FlutterwaveInterface
{
    public function initiateTransfer(
        float|int $amount,
        string $email,
        string $currency,
        string $reference
    );

    public function verifyTransfer(string $transactionId): string;
}