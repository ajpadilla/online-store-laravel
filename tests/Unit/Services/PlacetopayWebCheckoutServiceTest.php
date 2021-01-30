<?php

namespace Tests\Unit\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class PlacetopayWebCheckoutServiceTest extends ServiceTest
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function test_create_successful_request_to_placetopayweb()
    {
        /** @var array $data */
        $userData = $this->makeNewUserData();

        /** @var User $user */
        $user = $this->userRepository->create($userData);

        /** @var array $data */
        $productData = $this->makeNewProductData();

        /** @var Product $product*/
        $product = $this->productRepository->create($productData);

        /** @var array $data */
        $data = $this->makeNewOrderData($user,$product);

        /** @var Order $order*/
        $order = $this->orderRepository->create($data);

        $data = $this->placetopayWebCheckoutData($order);

        $response = $this->placetopayWebCheckoutService->createRequest($data);

        $this->assertEquals('OK',$response->status->status);
    }
}
