<?php

namespace Blinqpay\PaymentProcessor\PaymentGateways;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Blinqpay\PaymentProcessor\Contracts\FlutterwaveInterface;
use Blinqpay\PaymentProcessor\Exceptions\InternalServerException;

class Flutterwave implements FlutterwaveInterface
{

    public function __construct()
    {
    }

    /**
     * @param 
     * @return
     */
    public function initiateTransfer(
        float|int $amount, 
        string $email, 
        string $currency, 
        string $reference
    ) {
        try {
            $transfer = Http::withToken('FLWSECK_TEST-06436937225b106a42f48e192ff0dc89-X')->post(
                'https://api.flutterwave.com/v3/transactions/transfers',
                [
                    'payment_options' => 'card',
                    'amount' => $amount,
                    'email' => $email,
                    'tx_ref' => $reference,
                    'currency' => $currency,
                    'redirect_url' => 'http://127.0.0.1:8000/callback',
                ]
            )->json();

            return $transfer;
            
        } catch (\Exception $e) {
            throw new InternalServerException($e, 500);
        }
    }

    public function verifyTransfer(string $transactionId): string
    {
        try {
            $reponse =  Http::withToken('FLWSECK_TEST-06436937225b106a42f48e192ff0dc89-X')
                ->get("https://api.flutterwave.com/v3/transactions/" . $transactionId . '/verify')
                ->json();

            return $reponse;
        } catch (\Exception $e) {
            throw new InternalServerException($e, 500);
        }
    }
}
