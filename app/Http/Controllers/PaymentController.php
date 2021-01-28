<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentAttemptRepository;
use App\Services\Payment\PaymentService;
use App\Services\Placetopay\WebCheckout\PlacetopayWebCheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /** @var PaymentAttemptRepository */
    private $paymentAttemptRepository;

    /** @var OrderRepository */
    private $orderRepository;

    /** @var PaymentService */
    private $paymentService;

    /** @var PlacetopayWebCheckoutService */
    private $placetopayWebCheckoutService;

    /**
     * PaymentController constructor.
     * @param PaymentAttemptRepository $paymentAttemptRepository
     * @param OrderRepository $orderRepository
     * @param PaymentService $paymentService
     * @param PlacetopayWebCheckoutService $placetopayWebCheckoutService
     */
    public function __construct(
        PaymentAttemptRepository $paymentAttemptRepository,
        OrderRepository $orderRepository,
        PaymentService $paymentService,
        PlacetopayWebCheckoutService $placetopayWebCheckoutService
    )
    {
        $this->paymentAttemptRepository = $paymentAttemptRepository;
        $this->orderRepository = $orderRepository;
        $this->paymentService = $paymentService;
        $this->placetopayWebCheckoutService = $placetopayWebCheckoutService;
    }

    public function show()
    {
        return view('layouts.orders.pay');
    }

    public function process()
    {
        /** @var Order $order */
        $order = $this->orderRepository->getByUserId(Auth::user()->id);

        $data = $this->paymentService->generateRequestData($order);

        $response = $this->placetopayWebCheckoutService->createRequest($data);

        $paymentAttemp = $this->paymentAttemptRepository->create([
            'external_id',
            'url_process',
            'state' => 'INITIAL',
            'order_id' => $order->id
        ]);

        //Redirecionar hacia placetopay
    }
}
