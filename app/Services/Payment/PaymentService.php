<?php


namespace App\Services\Payment;


use App\Models\Order;

class PaymentService
{
    public function generateRequestData(Order $order)
    {
        $data = [
            "buyer" => [
                "name" => "River",
                "surname" => "Dickens",
                "email" => "dnetix@yopmail.com",
                "document" => "1040035000",
                "documentType" => "CC",
                "mobile" => 3006108300
            ],
            "payment" => [
                "reference" => "TEST_20210126_165513",
                "description" => "Animi hic hic voluptas.",
                "amount" => [
                    "currency" => "COP",
                    "total" => 149000
                ]
            ],
            "expiration" => "2021-01-27T17:55:13-05:00",
            "ipAddress" => "127.0.0.1",
            "returnUrl" => "http://localhost:8089/show",
            "userAgent" => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36",
            "paymentMethod" => null,
        ];

        return $data;
    }
}
