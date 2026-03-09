<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('is_admin', false)->get();

        $customers = [
            ['customer_name' => 'Amit Sharma',   'shop_name' => 'Sharma Traders',       'shop_address' => '12, Market Road',     'city' => 'Ahmedabad', 'customer_number' => '9876543210', 'customer_email' => 'amit@sharma.com',   'status' => 1, 'latitude' => '23.0225', 'longitude' => '72.5714'],
            ['customer_name' => 'Bharat Joshi',  'shop_name' => 'Joshi General Store',  'shop_address' => '45, Station Road',    'city' => 'Surat',     'customer_number' => '9876543211', 'customer_email' => 'bharat@joshi.com',  'status' => 1, 'latitude' => '21.1702', 'longitude' => '72.8311'],
            ['customer_name' => 'Chirag Modi',   'shop_name' => 'Modi Electronics',     'shop_address' => '8, Ring Road',        'city' => 'Vadodara',  'customer_number' => '9876543212', 'customer_email' => 'chirag@modi.com',   'status' => 1, 'latitude' => '22.3072', 'longitude' => '73.1812'],
            ['customer_name' => 'Deepak Verma',  'shop_name' => 'Verma Wholesale',      'shop_address' => '22, Industrial Area', 'city' => 'Rajkot',    'customer_number' => '9876543213', 'customer_email' => 'deepak@verma.com',  'status' => 0, 'latitude' => '22.3039', 'longitude' => '70.8022'],
            ['customer_name' => 'Ekta Singh',    'shop_name' => 'Singh Departmental',   'shop_address' => '55, Old City',        'city' => 'Gandhinagar','customer_number' => '9876543214', 'customer_email' => 'ekta@singh.com',   'status' => 1, 'latitude' => '23.2156', 'longitude' => '72.6369'],
            ['customer_name' => 'Farhan Khan',   'shop_name' => 'Khan Brothers',        'shop_address' => '3, Bazaar Street',    'city' => 'Anand',     'customer_number' => '9876543215', 'customer_email' => 'farhan@khan.com',   'status' => 1, 'latitude' => '22.5645', 'longitude' => '72.9289'],
            ['customer_name' => 'Gopal Das',     'shop_name' => 'Das Grocery',          'shop_address' => '77, Main Market',     'city' => 'Mehsana',   'customer_number' => '9876543216', 'customer_email' => 'gopal@das.com',     'status' => 1, 'latitude' => '23.5879', 'longitude' => '72.3693'],
            ['customer_name' => 'Heena Patel',   'shop_name' => 'Patel Super Mart',    'shop_address' => '90, Highway',         'city' => 'Junagadh',  'customer_number' => '9876543217', 'customer_email' => 'heena@patel.com',   'status' => 0, 'latitude' => '21.5222', 'longitude' => '70.4579'],
            ['customer_name' => 'Imran Sheikh',  'shop_name' => 'Sheikh Medical',       'shop_address' => '14, Cross Road',      'city' => 'Bhavnagar', 'customer_number' => '9876543218', 'customer_email' => 'imran@sheikh.com',  'status' => 1, 'latitude' => '21.7645', 'longitude' => '72.1519'],
            ['customer_name' => 'Jayesh Trivedi','shop_name' => 'Trivedi Provisions',  'shop_address' => '60, Nehru Nagar',     'city' => 'Ahmedabad', 'customer_number' => '9876543219', 'customer_email' => 'jayesh@trivedi.com','status' => 1, 'latitude' => '23.0395', 'longitude' => '72.5266'],
            ['customer_name' => 'Ketan Shah',    'shop_name' => 'Shah Hardware',        'shop_address' => '19, Sector 5',        'city' => 'Surat',     'customer_number' => '9876543220', 'customer_email' => 'ketan@shah.com',    'status' => 1, 'latitude' => '21.2295', 'longitude' => '72.8347'],
            ['customer_name' => 'Lata Gupta',    'shop_name' => 'Gupta Saree House',   'shop_address' => '34, Gandhi Road',     'city' => 'Vadodara',  'customer_number' => '9876543221', 'customer_email' => 'lata@gupta.com',    'status' => 1, 'latitude' => '22.3217', 'longitude' => '73.1673'],
        ];

        // Distribute customers evenly among users
        foreach ($customers as $index => $data) {
            $user = $users[$index % $users->count()];
            Customer::create(array_merge($data, ['user_id' => $user->id]));
        }
    }
}
