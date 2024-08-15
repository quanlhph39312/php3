<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake = Faker::create();

        for($i=0; $i<10; $i++){
            DB::table('categories')->insert([
                'name' => $fake->text(25),
                'image' => 'https://web.hn.ss.bfcplatform.vn/muadienmay/content/article2/0878913035-1620532649.jpg',
            ]);
        }
    }
}
