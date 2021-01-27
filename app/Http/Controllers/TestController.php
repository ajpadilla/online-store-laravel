<?php

namespace App\Http\Controllers;

use App\Services\Placetopay\WebCheckout\PlacetopayWebCheckoutService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TestController extends Controller
{
    private $placetopayWebCheckoutService;
    public function __construct(PlacetopayWebCheckoutService $placetopayWebCheckoutService)
    {
        $this->placetopayWebCheckoutService = $placetopayWebCheckoutService;
    }

    /*public function index(Request $request)
    {
        return redirect('show');
    }*/

    public function show(Request $request)
    {
        echo "show";
    }

    public function index(Request $request){

        $country_name_length = $request->country_name_length;

        if ($country_name_length < 3){
            //return redirect('show');
            //return redirect('/search')->with('status', 'Profile updated!');
            //return response()->json(["status" => "FAILED", "status_message" => "algo"], 400)->header('Content-Type', 'application/json');
            //return response('Hello World', 200)
                //->header('Content-Type', 'text/plain');
            //return Carbon::now()->format('c');
            //return date('c');
             dd($this->placetopayWebCheckoutService->createRequest([]));
        }

        $counties = [];

        return view('countries.index', compact('counties'));
    }

    public function search(Request $request){
        dd($this->placetopayWebCheckoutService->getRequestInformation('448246'));
    }
}
