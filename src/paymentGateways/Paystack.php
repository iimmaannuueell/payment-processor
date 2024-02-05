<?php

namespace Blinqpay\PaymentProcessor\PaymentGateways;

use Illuminate\Support\Facades\Http;
use Blinqpay\PaymentProcessor\Contracts\PaystackInterface;
use Blinqpay\PaymentProcessor\Exceptions\InternalServerException;

class Paystack implements PaystackInterface
{

    public function __construct()
    {
    }

    /**
     * @param 
     * @return
     */
    public function initiateTransfer(float|int $amount) {
        // TODO: create transactionin in pending state
        try {
            $response = Http::withToken('sk_test_fd69ec83c78370122673ee8fecee066f446971ce')->post(
                'https://api.paystack.co/transaction/initialize',
                [
                    "email"=> "customer@email.com", 
                    "amount"=> "20000"
                ]
            )->json();

            return $response;
        
            // if ($response->successful()) {
                // return $response;
            // } 
            // if ($response->clientError()) {
            //     throw new InternalServerException('bad response', 400);
            // } 
            // if ($response->requestTimeout()) {

            // }
        } catch (\Exception $e) {
            // throw_if($e instanceof)
            throw new InternalServerException($e, 500);
        }
    }

    public function verifyTransfer(string $transactionId): string
    {
        return $transactionId;
        // $data =  Http::withToken(config('paymentRouter.flwPublicKey'))
        //     ->get(config('paymentRouter.flwBaseUrl') . "/transactions/" . $transactionId . '/verify')
        //     ->json();
        // return $data;
    }
}
