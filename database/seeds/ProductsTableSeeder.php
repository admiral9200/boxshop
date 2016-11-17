<?php

use App\Business as Business;
use App\Product as Product;
use App\ProductOffer as ProductOffer;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $businesses = Business::get();
        $numCategories = DB::table('categories')->count();
        for ($i = 0; $i < 100; $i++) {
            $price = $faker->numberBetween(1, 99);
            $stock = $faker->numberBetween(20, 50);
            $tag = $faker->randomElement(['16 BRAND DRAW COLOR',
                            '16 BRAND BRICKIT SHADOW',
                            '16 BRAND FOUNDATION',
                            '16 BRAND FINGERPEN',
                            '16 BRAND FINGERPEN',
                            'PINK TONE UP',
                            '16 BLUR PACT SPF50+PA+++']);
            $id = Product::create([
                'category_id'  => $faker->numberBetween(1, $numCategories),
                'user_id'      => '3',
                'status'       => 1,
                'type'         => 'beaty',
                'sale_counts'  => $faker->randomNumber(9),
                'view_counts'  => $faker->randomNumber(9),
                'name'         => $faker->randomElement(['16 BRAND DRAW COLOR',
                            '16 BRAND BRICKIT SHADOW',
                            '16 BRAND FOUNDATION',
                            '16 BRAND FINGERPEN',
                            '16 BRAND FINGERPEN',
                            'PINK TONE UP',
                            '16 BLUR PACT SPF50+PA+++']),
                'description'  => '',
                'price'        => $price,
                'stock'        => $stock,
                'brand'        => $faker->randomElement(['Skin1004', 'DayCell', 'Ottie', '16 Brand', 'Son Park', 'Clinique']),
                'features'     => json_encode([
                    'images' => [
                    '/img/pt-default/'.$faker->numberBetween(1, 8).'.jpg',
                    '/img/pt-default/'.$faker->numberBetween(1, 8).'.jpg',
                    '/img/pt-default/'.$faker->numberBetween(1, 8).'.jpg',
                    '/img/pt-default/'.$faker->numberBetween(1, 8).'.jpg',
                    '/img/pt-default/'.$faker->numberBetween(1, 8).'.jpg',
                    ],
                ]),
                'condition' => $faker->randomElement(['new', 'refurbished', 'used']),
                'low_stock' => $faker->randomElement([5, 10, 15]),
                'tags'      => json_encode($tag.','.$tag.','.$tag),
            ]);
            if ($faker->numberBetween(0, 1)) {
                $percentage = $faker->randomElement([10, 15, 25, 35, 50]);
                ProductOffer::create([
                    'product_id' => $id->id,
                    'day_start'  => $faker->dateTime(),
                    'day_end'    => $faker->dateTimeBetween('now', '+1 years'),
                    'percentage' => $percentage,
                    'price'      => (($percentage * $price) / 100),
                    'quantity'   => round($stock / 2),
                ]);
            }
        }
    }
}
