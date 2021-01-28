<?php

namespace Database\Seeders;

use App\Repositories\ProductRepository;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
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
        /** @var ProductRepository $productRepository */
        $productRepository = app(ProductRepository::class);

        for ($i = 0; $i <= 10; $i++)
        {
            $productRepository->create([
                'name' => $this->faker->text($maxNbChars = 10),
                'price' =>  $this->faker->numberBetween($min = 1500, $max = 6000)
            ]);
        }
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
}
