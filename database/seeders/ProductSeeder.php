<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('is_admin', false)->get();

        $products = [
            ['product_name' => 'Basmati Rice 5kg',         'product_base_price' => 350.00,  'status' => 1],
            ['product_name' => 'Toor Dal 1kg',             'product_base_price' => 120.00,  'status' => 1],
            ['product_name' => 'Sunflower Oil 1L',         'product_base_price' => 145.00,  'status' => 1],
            ['product_name' => 'Wheat Flour 10kg',         'product_base_price' => 280.00,  'status' => 1],
            ['product_name' => 'Sugar 1kg',                'product_base_price' => 45.00,   'status' => 1],
            ['product_name' => 'Salt 1kg',                 'product_base_price' => 20.00,   'status' => 1],
            ['product_name' => 'Turmeric Powder 100g',    'product_base_price' => 35.00,   'status' => 1],
            ['product_name' => 'Red Chilli Powder 200g',  'product_base_price' => 55.00,   'status' => 0],
            ['product_name' => 'Mustard Oil 1L',           'product_base_price' => 160.00,  'status' => 1],
            ['product_name' => 'Ghee 500ml',               'product_base_price' => 280.00,  'status' => 1],
            ['product_name' => 'Green Tea 100 Bags',       'product_base_price' => 180.00,  'status' => 1],
            ['product_name' => 'Biscuit Pack 12pcs',       'product_base_price' => 60.00,   'status' => 1],
            ['product_name' => 'Detergent Powder 1kg',    'product_base_price' => 95.00,   'status' => 1],
            ['product_name' => 'Soap Bar 100g',            'product_base_price' => 25.00,   'status' => 1],
            ['product_name' => 'Shampoo 200ml',            'product_base_price' => 110.00,  'status' => 0],
        ];

        foreach ($products as $index => $data) {
            $user = $users[$index % $users->count()];
            Product::create(array_merge($data, ['user_id' => $user->id]));
        }
    }
}
