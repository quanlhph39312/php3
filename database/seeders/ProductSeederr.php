<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductSeederr extends Seeder
{

    public function run(): void
    {
        $fake = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            DB::table('products')->insert([
                'name' => $fake->text(35),
                'category_id' => rand(1, 10),
                'image_thumbnail' => 'https://thuthuatnhanh.com/wp-content/uploads/2022/12/hinh-anh-ho-ly-9-duoi-hung-du.jpg',
                'price_regular' => rand(500, 1000),
                'price_sale' => rand(400, 500),
                'description' => $fake->text(150),
                'material' => $fake->text(10),
                'view' => rand(100, 9000),
            ]);
        }
    }
}
