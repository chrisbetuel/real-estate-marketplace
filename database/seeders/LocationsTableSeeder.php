<?php
// database/seeders/LocationsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationsTableSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            // Real Estate Agencies
            [
                'name' => 'Dream Homes Realty',
                'type' => 'agency',
                'category' => 'real_estate',
                'address' => '123 Main St',
                'city' => 'Miami',
                'state' => 'FL',
                'zip_code' => '33101',
                'latitude' => 25.7617,
                'longitude' => -80.1918,
                'phone' => '(305) 555-0123',
                'email' => 'info@dreamhomes.com',
                'website' => 'https://dreamhomes.com',
                'is_verified' => true,
            ],
            // Professionals (Agents)
            [
                'name' => 'Sarah Johnson - Realtor',
                'type' => 'professional',
                'category' => 'real_estate_agent',
                'address' => '456 Ocean Ave',
                'city' => 'Miami Beach',
                'state' => 'FL',
                'zip_code' => '33139',
                'latitude' => 25.7907,
                'longitude' => -80.1300,
                'phone' => '(305) 555-0456',
                'email' => 'sarah@dreamhomes.com',
                'is_verified' => true,
            ],
            // Home Improvement Stores
            [
                'name' => 'Home & Garden Supply',
                'type' => 'store',
                'category' => 'home_improvement',
                'address' => '789 Commerce Blvd',
                'city' => 'Miami',
                'state' => 'FL',
                'zip_code' => '33142',
                'latitude' => 25.7954,
                'longitude' => -80.2556,
                'phone' => '(305) 555-0789',
                'website' => 'https://homegarden.com',
                'is_verified' => true,
            ],
            // Mortgage Brokers
            [
                'name' => 'First Choice Mortgage',
                'type' => 'professional',
                'category' => 'mortgage_broker',
                'address' => '321 Financial Plaza',
                'city' => 'Miami',
                'state' => 'FL',
                'zip_code' => '33131',
                'latitude' => 25.7743,
                'longitude' => -80.1887,
                'phone' => '(305) 555-0321',
                'email' => 'info@firstchoice.com',
                'website' => 'https://firstchoice.com',
                'is_verified' => true,
            ],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}