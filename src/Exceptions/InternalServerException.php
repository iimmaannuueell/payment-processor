<?php

namespace Blinqpay\PaymentProcessor\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InternalServerException extends Exception
{
/**
     * InternalServerException constructor.
     */
    public function __construct(?string $message, int $code = 500)
    {
        parent::__construct($message, $code);
    }
    
    public function render(): JsonResponse|string
    {
        $response = ['success' => 'falsem', 'message' => $this->message];
        // if (count($this->errors) > 0) {
        //     $response['errors'] = $this->errors;
        // }

        return response()->json($response, $this->code);
    }
}
