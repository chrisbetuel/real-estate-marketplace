<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class StoreSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Create store owner users if not exist
        $storeOwners = User::where('user_type', 'store_owner')->get();
        if ($storeOwners->isEmpty()) {
            $storeOwners = collect();
            for ($i = 0; $i < 5; $i++) {
                $user = User::create([
                    'name' => $faker->name,
                    'email' => 'store' . $i . '@example.com',
                    'password' => Hash::make('password'),
                    'user_type' => 'store_owner',
                    'phone' => $faker->phoneNumber,
                ]);
                $storeOwners->push($user);
            }
        }

        // Create stores
        for ($i = 0; $i < 8; $i++) {
            Store::create([
                'name' => $faker->company,
                'description' => $faker->sentence(15),
                'logo' => 'store-logos/default.png',
                'email' => $faker->companyEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'zip_code' => $faker->postcode,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
                'owner_id' => $storeOwners[$i % $storeOwners->count()]->id,
                'is_active' => true,
                'is_verified' => true,
            ]);
        }

        $this->command->info('Stores seeded successfully!');
    }
}

