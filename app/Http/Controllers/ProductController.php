<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\ProductRepository;
use App\Services\Product\ProductService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Utils;

class ProductController extends Controller
{

    /** @var ProductRepository */
    private $productRepository;

    /** @var ProductService */
    private $productService;

    public function __construct(ProductService $productService, ProductRepository $productRepository)
    {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }

    public function Buy(Request $request, $id)
    {
        /** @var User $user */
        if(!$user = Auth::user()) {
            return redirect()->back()->withErrors("You must create a new account or log in to make the purchase");
        }

        try {
            DB::beginTransaction();

            /** @var Product $products */
            $product = $this->productRepository->find($id);

            /** @var Order $order */
            $order = $this->productService->buy($user, $product);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()->back()->withErrors($exception->getMessage());
        }

        return view('layouts.orders.customer_order', compact('order'));
    }
}
