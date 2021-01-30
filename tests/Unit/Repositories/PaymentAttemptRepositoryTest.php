<?php

namespace Tests\Unit\Repositories;

use App\Models\Order;
use App\Models\PaymentAttempt;
use App\Models\Product;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class PaymentAttemptRepositoryTest extends RepositoryTest
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_a_new_paymentAttemp()
    {
        /** @var array $userData */
        $userData = $this->makeNewUserData();

        /** @var User $user */
        $user = $this->userRepository->create($userData);

        /** @var array $productData */
        $productData = $this->makeNewProductData();

        /** @var Product $product*/
        $product = $this->productRepository->create($productData);

        /** @var array $data */
        $data = $this->makeNewOrderData($user,$product);

        /** @var Order $order*/
        $order = $this->orderRepository->create($data);

        /** @var array $paymentAttemptData */
        $paymentAttemptData = $this->makeNewPaymentAttemptData($order);

        /** @var PaymentAttempt $paymentAttempt */
        $paymentAttempt = $this->paymentAttemptRepository->create($paymentAttemptData);

        $this->assertNotNull($paymentAttempt);
    }

    public function test_search_a_existing_paymentAttemp()
    {
        /** @var array $userData */
        $userData = $this->makeNewUserData();

        /** @var User $user */
        $user = $this->userRepository->create($userData);

        /** @var array $productData */
        $productData = $this->makeNewProductData();

        /** @var Product $product*/
        $product = $this->productRepository->create($productData);

        /** @var array $data */
        $data = $this->makeNewOrderData($user,$product);

        /** @var Order $order*/
        $order = $this->orderRepository->create($data);

        /** @var array $paymentAttemptData */
        $paymentAttemptData = $this->makeNewPaymentAttemptData($order);

        /** @var PaymentAttempt $paymentAttempt */
        $paymentAttempt = $this->paymentAttemptRepository->create($paymentAttemptData);

        $this->assertNotNull($this->paymentAttemptRepository->find($paymentAttempt));
    }
}
