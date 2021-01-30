<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class UserRepositoryTest extends RepositoryTest
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_a_new_user()
    {
        /** @var array $data */
        $data = $this->makeNewUserData();

        /** @var User $user */
        $user = $this->userRepository->create($data);

        $this->assertNotNull($user);
    }

    public function test_search_a_exist_user()
    {
        /** @var array $data */
        $data = $this->makeNewUserData();

        /** @var User $user */
        $user = $this->userRepository->create($data);

        $user = $this->userRepository->find($user->id);

        $this->assertNotNull($user);
    }
}
