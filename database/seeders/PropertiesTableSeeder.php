<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user or create one - but check if exists first
        $user = User::where('email', 'agent@example.com')->first();
        
        if (!$user) {
            // Try to get any user
            $user = User::first();
            
            // If still no user, create one
            if (!$user) {
                $user = User::create([
                    'name' => 'Test Agent',
                    'email' => 'agent@example.com',
                    'password' => Hash::make('password'),
                    'user_type' => 'agent',
                    'phone' => '1234567890',
                    'address' => '123 Agent Street',
                    'is_verified' => 1,
                    'is_active' => 1,
                ]);
                $this->command->info('Test agent created successfully.');
            } else {
                $this->command->info('Using existing user: ' . $user->email);
            }
        } else {
            $this->command->info('Found existing agent: ' . $user->email);
        }

        // Clear existing properties with ID 7 if exists (to avoid conflicts)
        Property::where('id', 7)->delete();

        // Create test properties
        $this->command->info('Creating test properties...');

        Property::create([
            'title' => 'Luxury Beach House',
            'description' => 'Beautiful beachfront property with ocean views',
            'price' => 750000.00,
            'address' => '123 Ocean Drive',
            'city' => 'Miami Beach',
            'state' => 'FL',
            'zip_code' => '33139',
            'bedrooms' => 4,
            'bathrooms' => 3,
            'square_feet' => 2500,
            'property_type' => 'house',
            'status' => 'available',
            'user_id' => $user->id
        ]);

        Property::create([
            'title' => 'Downtown Apartment',
            'description' => 'Modern apartment in the heart of the city',
            'price' => 350000.00,
            'address' => '456 Main St',
            'city' => 'New York',
            'state' => 'NY',
            'zip_code' => '10001',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'square_feet' => 1200,
            'property_type' => 'apartment',
            'status' => 'available',
            'user_id' => $user->id
        ]);

        // Create property with ID 7 specifically (for your test)
        Property::create([
            'id' => 7,
            'title' => 'Test Property for Messages',
            'description' => 'This property is for testing conversations',
            'price' => 100000.00,
            'address' => '789 Test Ave',
            'city' => 'Test City',
            'state' => 'CA',
            'zip_code' => '90210',
            'bedrooms' => 3,
            'bathrooms' => 2,
            'square_feet' => 1800,
            'property_type' => 'house',
            'status' => 'available',
            'user_id' => $user->id
        ]);

        $this->command->info('Properties created successfully!');
    }
}