<?php

namespace Tests\Unit;

use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
//use PHPUnit\Framework\TestCase;

use Tests\TestCase;

class ExampleTest extends TestCase
{

    use RefreshDatabase;

    private $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = app(UserRepository::class);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        /** @var UserRepository $userRepository */
        $userRepository = app(UserRepository::class);

        //User Admin
        $user = $userRepository->create([
            'name' => 'Admins',
            'email' => 'Admins@example.com',
            'password' => Hash::make('123456')
        ]);

        //$this->assertTrue(true);
    }
}
