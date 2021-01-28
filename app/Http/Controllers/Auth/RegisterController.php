<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /** @var UserRepository  */
    private $userRepository;

    /** @var OrderRepository  */
    private $orderRepository;

    /**
     * RegisterController constructor.
     * @param UserRepository $userRepository
     * @param OrderRepository $orderRepository
     */
    public function __construct(UserRepository $userRepository, OrderRepository $orderRepository)
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
    }

    public function show()
    {
        return view('auth.register');
    }

    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();

            /** @var User $user */
            $user = $this->userRepository->create([
                'name' =>  $request->input('fullname'),
                'email' =>  $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

            $this->orderRepository->create([
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_mobile' => $request->input('phone'),
                'customer_document_number' => $request->input('document_number'),
                'customer_document_type' => $request->input('document_type'),
                'amount' => 0,
                'status' => 'CREATED',
                'user_id' => $user->id,
            ]);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()->back()->withErrors($exception->getMessage());
        }

        return redirect()->back()->with('alert_success', 'User Register Successful.');
    }
}
