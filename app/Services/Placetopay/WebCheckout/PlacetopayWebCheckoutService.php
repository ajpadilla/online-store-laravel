<?php


namespace App\Services\Placetopay\WebCheckout;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Response;

class PlacetopayWebCheckoutService
{
    /** @var string */
    protected $endpoint;

    /**
     * PoBoxPurchaseService constructor.
     */
    public function __construct()
    {
        $this->endpoint = "https://test.placetopay.com/redirection/";
    }

    /**
     * @param $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exception
     */
    public function createRequest($data)
    {
        $client = $this->createClient(null);

        $nonce = $this->createNonce();

        $nonce_base64 = $this->createNonceBase64($nonce);

        $seed = $this->createSeed();

        $secretKey = "024h1IlD";

        $tranKey = $this->createTranKey($nonce, $seed, $secretKey);


        $data = [
            "buyer" =>  [
                "name" =>  "River",
                "surname" =>  "Dickens",
                "email" =>  "dnetix@yopmail.com",
                "document" =>  "1040035000",
                "documentType" => "CC",
                "mobile" =>  3006108300
            ],
            "payment" =>[
                "reference" => "TEST_20210126_165513",
                "description" =>  "Animi hic hic voluptas.",
                "amount" => [
                    "currency" => "COP",
                    "total" =>  149000
                ]
            ],
            "expiration" => "2021-01-27T17:55:13-05:00",
            "ipAddress" =>  "127.0.0.1",
            "returnUrl" => "http://localhost:8089/show",
            "userAgent" =>  "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36",
            "paymentMethod" => null,
            "auth" => [
                "login" =>  "6dd490faf9cb87a9862245da41170ff2",
                "tranKey" =>  "{$tranKey}",
                "nonce" =>  "{$nonce_base64}",
                "seed" => "{$seed}"
            ]
        ];

        try {
            /** @var Response $response */
            $response = $client->post('api/session/', [
                'json' => $data,
            ]);
        } catch (Exception $e) {
            logger($e->getMessage());
            logger($e->getTraceAsString());

            throw new Exception("Error getting access token");
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRequestInformation($id)
    {
        $client = $this->createClient(null);

        $nonce = $this->createNonce();

        $nonce_base64 = $this->createNonceBase64($nonce);

        $seed = $this->createSeed();

        $secretKey = "024h1IlD";

        $tranKey = $this->createTranKey($nonce, $seed, $secretKey);


        $data = [
            "auth" => [
                "login" =>  "6dd490faf9cb87a9862245da41170ff2",
                "tranKey" =>  "{$tranKey}",
                "nonce" =>  "{$nonce_base64}",
                "seed" => "{$seed}"
            ]
        ];

        try {
            /** @var Response $response */
            $response = $client->post("api/session/{$id}", [
                'json' => $data,
            ]);
        } catch (Exception $e) {
            logger($e->getMessage());
            logger($e->getTraceAsString());

            throw new Exception("Error getting access token");
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $authorization
     * @return GuzzleHttpClient
     */
    private function createClient($authorization)
    {
        return new GuzzleHttpClient([
            'base_uri' => $this->endpoint,
            'headers'  => ['Content-Type' => 'application/json'],
            'verify'   => false
        ]);
    }

    private function createNonce(){
        return bin2hex(openssl_random_pseudo_bytes(16));
    }

    private function createNonceBase64($nonce){
        return base64_encode($nonce);
    }

    private function createSeed(){
        return Carbon::now()->format('c');
    }

    private function createTranKey($nonce, $seed, $secretKey){
        return base64_encode(hash('sha1', $nonce. $seed . $secretKey, true));
    }
}
