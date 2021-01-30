<?php

namespace Tests\Unit\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\Payment\PaymentService;
use App\Services\Placetopay\WebCheckout\PlacetopayWebCheckoutService;
use App\Services\Product\ProductService;
use Carbon\Carbon;
//use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @var PlacetopayWebCheckoutService */
    protected $placetopayWebCheckoutService;

    /** @var ProductService */
    protected $productService;

    /** @var PaymentService */
    protected $paymentService;

    /** @var UserRepository */
    protected $userRepository;

    /** @var ProductRepository */
    protected $productRepository;

    /** @var OrderRepository */
    protected $orderRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->placetopayWebCheckoutService = app(PlacetopayWebCheckoutService::class);
        $this->userRepository = app(UserRepository::class);
        $this->productRepository = app(ProductRepository::class);
        $this->orderRepository = app(OrderRepository::class);
        $this->productService = app(ProductService::class);
        $this->paymentService = app(PaymentService::class);
    }

    protected function placetopayWebCheckoutData(Order $order)
    {
        $reference = 'TEST_' . time();
        $expiration_date = Carbon::now()->addDays(1)->format('c');

        return [
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
            'amount' => $product->price,
            'status' => 'CREATED',
            'user_id' => $user->id,
            'product_id' => $product->id
        ];
    }


    protected function createNewOrderDataWithoutAssociatedProduct(User $user)
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
            'product_id' => null
        ];
    }
}
