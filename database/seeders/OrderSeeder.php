<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('is_admin', false)->get();

        $statuses = ['pending', 'completed', 'cancelled'];

        foreach ($users as $user) {
            $customers = Customer::where('user_id', $user->id)->get();
            $products  = Product::where('user_id', $user->id)->get();

            if ($customers->isEmpty() || $products->isEmpty()) {
                continue;
            }

            // Create 15–20 orders per user spread across last 90 days
            $orderCount = rand(15, 20);

            for ($i = 0; $i < $orderCount; $i++) {
                $customer  = $customers->random();
                $product   = $products->random();
                $quantity  = round(rand(1, 50) * 0.5, 1); // 0.5 to 25 in 0.5 steps
                $orderDate = Carbon::now()->subDays(rand(0, 90))->format('Y-m-d');

                Order::create([
                    'user_id'        => $user->id,
                    'customer_id'    => $customer->id,
                    'product_id'     => $product->id,
                    'order_quantity' => $quantity,
                    'order_price'    => round($product->product_base_price * $quantity, 2),
                    'order_date'     => $orderDate,
                    'status'         => $statuses[array_rand($statuses)],
                ]);
            }
        }
    }
}
