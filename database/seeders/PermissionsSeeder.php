<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\PaymentAttempt;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentAttemptRepository;
use App\Repositories\UserRepository;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{

    /** @var Generator  */
    private $faker;

    /**
     * ProductsSeeder constructor.
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var UserRepository $userRepository */
        $userRepository = app(UserRepository::class);

        /** @var OrderRepository $orderRepository */
        $orderRepository = app(OrderRepository::class);

        /** @var PaymentAttemptRepository $paymentAttemptRepository */
        $paymentAttemptRepository = app(PaymentAttempt::class);

        //Permission list
        Permission::create(['name' => 'list.all.orders']);

        //Admin
        $admin = Role::create(['name' => 'Admin']);

        $admin->givePermissionTo([
            'list.all.orders',
        ]);


        //User Admin
        $user = $userRepository->create([
            'name' => 'Admin',
            'email' => 'Admin@example.com',
            'password' => Hash::make('123456')
        ]);

        $user->assignRole('Admin');

        /** @var Order $order */
        $order = $orderRepository->create([
            'customer_name' => $this->faker->firstName,
            'customer_last_name' => $this->faker->lastName,
            'customer_email' => $this->faker->email,
            'customer_mobile' => $this->faker->phoneNumber,
            'customer_document_number' => '1090538589',
            'customer_document_type' => 'CC',
            'amount' => 0,
            'status' => 'CREATED',
            'user_id' => $user->id,
        ]);

        $paymentAttemptRepository->create([
            'state' => 'INITIAL',
            'order_id' => $order->id
        ]);
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
}
