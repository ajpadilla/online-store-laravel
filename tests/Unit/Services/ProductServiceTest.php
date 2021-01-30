<?php

namespace Tests\Unit\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends ServiceTest
{
    /**
     * @throws \Exception
     */
    public function test_add_product_to_existing_order()
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
        $data = $this->createNewOrderDataWithoutAssociatedProduct($user);

        $this->orderRepository->create($data);

        /** @var Order $order*/
        $order = $this->productService->addProductToOrder($user, $product);

        $this->assertNotNull($order->product);
    }
}
