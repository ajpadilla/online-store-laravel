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

    const TIMEOUT = 15;

    const CONNECT_TIMEOUT = 5;

    /**
     * PoBoxPurchaseService constructor.
     */
    public function __construct()
    {
        $this->endpoint = env('TEST_PLACETOPAY_URL');
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

        $secretKey = env('TEST_PLACETOPAY_SECRET_KEY');

        $tranKey = $this->createTranKey($nonce, $seed, $secretKey);

        $result_data = array_merge($data, ["auth" => [
            "login" => env('TEST_PLACETOPAY_LOGIN'),
            "tranKey" => "{$tranKey}",
            "nonce" => "{$nonce_base64}",
            "seed" => "{$seed}"
        ]]);

        try {
            /** @var Response $response */
            $response = $client->post('api/session/', [
                'json' => $result_data,
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

        $secretKey = env('TEST_PLACETOPAY_SECRET_KEY');

        $tranKey = $this->createTranKey($nonce, $seed, $secretKey);

        $data = [
            "auth" => [
                "login" => env('TEST_PLACETOPAY_LOGIN'),
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
            'verify'   => false,
            'timeout' => self::TIMEOUT,
            'connect_timeout' => self::CONNECT_TIMEOUT
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
