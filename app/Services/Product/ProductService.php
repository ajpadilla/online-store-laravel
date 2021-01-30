<?php


namespace App\Services\Product;


use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Exception;

class ProductService
{
    /** @var OrderRepository */
    private $orderRepository;

    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository, OrderRepository $orderRepository)
    {
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param User $user
     * @param Product $product
     * @return Order
     * @throws Exception
     */
    public function addProductToOrder(User $user, Product $product)
    {
        /** @var Order $order */
        if(!$order = $this->orderRepository->getByUserId($user->id)){
            throw new Exception('There is no order associated with the user');
        }

        if ($order->getTotalProducts() > 0){
            throw new Exception('The order already has an associated product');
        }

        $this->orderRepository->associateProduct($order, $product);

        return $order;
    }

}
