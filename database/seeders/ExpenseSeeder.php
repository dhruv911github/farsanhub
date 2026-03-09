<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('is_admin', false)->get();

        $purposes = [
            'Travel & Fuel',
            'Office Supplies',
            'Client Entertainment',
            'Telephone & Internet',
            'Delivery Charges',
            'Packaging Material',
            'Maintenance',
            'Advertisement',
            'Staff Refreshments',
            'Miscellaneous',
        ];

        foreach ($users as $user) {
            // Create 20–30 expenses per user across last 90 days
            $count = rand(20, 30);

            for ($i = 0; $i < $count; $i++) {
                $purpose = $purposes[array_rand($purposes)];
                $amount  = round(rand(100, 5000) + rand(0, 99) / 100, 2);
                $date    = Carbon::now()->subDays(rand(0, 90))->format('Y-m-d');

                Expense::create([
                    'user_id' => $user->id,
                    'amount'  => $amount,
                    'purpose' => $purpose,
                    'comment' => "Expense for $purpose on $date",
                    'date'    => $date,
                ]);
            }
        }
    }
}
