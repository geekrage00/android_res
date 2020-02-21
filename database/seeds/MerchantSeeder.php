<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Merchant;

class MerchantSeeder extends Seeder
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
        for($i = 1;$i<=3;$i++){
            $name = $faker->name;
            Merchant::create(
                [
                    "merchantName"=>$name,
                    "merchantSlug"=>Str::slug($name)
                ]
            );
        }

    }
}
