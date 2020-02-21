<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        for($i = 1;$i<=10;$i++){
            $name = $faker->productName;
            Product::create(
                [
                    "productName"=>$name,
                    "productSlug"=>Str::slug($name),
                    "productQty"=>$faker->numberBetween(1,10),
                    "productImage"=>"images/products/product_image_1280x780.png",
                    "categoryId"=>$faker->numberBetween(1,3),
                    "merchantId"=>$faker->numberBetween(1,3)
                ]
            );
        }
    }
}
