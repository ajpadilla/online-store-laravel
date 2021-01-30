<?php

namespace Tests\Unit\Repositories;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentAttemptRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @var UserRepository */
    protected $userRepository;

    /** @var ProductRepository */
    protected $productRepository;

    /** @var OrderRepository */
    protected $orderRepository;

    /** @var PaymentAttemptRepository */
    protected $paymentAttemptRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = app(UserRepository::class);
        $this->productRepository = app(ProductRepository::class);
        $this->orderRepository = app(OrderRepository::class);
        $this->paymentAttemptRepository = app(PaymentAttemptRepository::class);
    }

    /**
     * @return array
     */
    protected function makeNewUserData()
    {
        return[
            'name' =>  $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => Hash::make("{$this->faker->randomNumber()}")
        ];
    }

    /**
     * @return array
     */
    protected function makeNewProductData()
    {
        return [
            'name' => $this->faker->text($maxNbChars = 10),
            'price' =>  $this->faker->numberBetween($min = 1500, $max = 6000)
        ];
    }

    /**
     * @param User $user
     * @return array
     */
    protected function makeNewOrderData(User $user, Product $product)
    {
        return [
            'customer_name' => $this->faker->firstName,
            'customer_last_name' => $this->faker->lastName,
            'customer_email' => $this->faker->email,
            'customer_mobile' => $this->faker->phoneNumber,
            'customer_document_number' => '1090538589',
            'customer_document_type' => 'CC',
            'amount' => 0,
            'status' => 'CREATED',
            'user_id' => $user->id,
            'product_id' => $product->id
        ];
    }

    public function makeNewPaymentAttemptData(Order $order)
    {
        return [
            'external_id' => $this->faker->randomNumber(4),
            'url_process' => $this->faker->url,
            'state'       => array_rand(['INITIAL', 'REJECTED', 'APPROVED', 'FAILED']),
            'order_id'    => $order->id
        ];
    }
}
