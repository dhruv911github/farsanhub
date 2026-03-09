<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductPriceSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('is_admin', false)->get();

        foreach ($users as $user) {
            $products  = Product::where('user_id', $user->id)->get();
            $customers = Customer::where('user_id', $user->id)->get();

            // Assign custom prices for each product to a subset of customers
            foreach ($products as $product) {
                // Pick 2-3 random customers to have custom pricing
                $selectedCustomers = $customers->random(min(3, $customers->count()));

                foreach ($selectedCustomers as $customer) {
                    // Skip if already exists (idempotent)
                    $exists = ProductPrice::where('product_id', $product->id)
                        ->where('customer_id', $customer->id)
                        ->exists();

                    if (!$exists) {
                        // Custom price: base price ± 5–20%
                        $discount = rand(5, 20) / 100;
                        $direction = rand(0, 1) ? 1 : -1;
                        $customPrice = round($product->product_base_price * (1 + $direction * $discount), 2);

                        ProductPrice::create([
                            'user_id'     => $user->id,
                            'product_id'  => $product->id,
                            'customer_id' => $customer->id,
                            'price'       => max(1, $customPrice),
                        ]);
                    }
                }
            }
        }
    }
}
