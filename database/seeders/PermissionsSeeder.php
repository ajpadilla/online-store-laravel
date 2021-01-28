<?php

namespace Database\Seeders;

use App\Repositories\UserRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var UserRepository $userRepository */
        $userRepository = app(UserRepository::class);

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
    }
}
