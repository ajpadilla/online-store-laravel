<?php


namespace App\Services\Payment;


use App\Models\Order;
use Carbon\Carbon;

class PaymentService
{
    public function generateRequestData(Order $order)
    {

        $reference = 'TEST_' . time();
        $expiration_date = Carbon::now()->addDays(1)->format('c');

        $data = [
            "buyer" => [
                "name" => "{$order->customer_name}",
                "surname" => "{$order->customer_last_name}",
                "email" => "{$order->customer_email}",
                "document" => "{$order->customer_document_number}",
                "documentType" => "{$order->customer_document_type}",
                "mobile" => $order->customer_mobile
            ],
            "payment" => [
                "reference" => "{$reference}",
                "description" => "Animi hic hic voluptas.",
                "amount" => [
                    "currency" => "COP",
                    "total" => $order->amount
                ]
            ],
            "expiration" => "{$expiration_date}",
            "ipAddress" => "127.0.0.1",
            "returnUrl" => "http://localhost:8089/update/order/state",
            "userAgent" => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36",
            "paymentMethod" => null,
        ];

        return $data;
    }
}
