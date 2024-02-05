<?php

namespace Blinqpay\PaymentProcessor\Enums;

enum LogStatus: string
{
   case PENDING = 'pending';
   case SUCCESSFUL = 'successful';
   case FAILED = 'failed';
}