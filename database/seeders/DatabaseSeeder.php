<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProfessionalProfile;
use App\Models\Store;
use App\Models\Product;
use App\Models\Job;
use App\Models\Bid;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call other seeders first
        $this->call([
            AdminSeeder::class,
            LocationsTableSeeder::class,
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'phone' => '1234567890',
            'address' => 'Admin Address',
            'is_verified' => true,
            'is_active' => true
        ]);

        // Create sample clients
        $clients = [];
        for ($i = 1; $i <= 5; $i++) {
            $clients[] = User::create([
                'name' => "Client {$i}",
                'email' => "client{$i}@example.com",
                'password' => Hash::make('password'),
                'user_type' => 'client',
                'phone' => "123456789{$i}",
                'address' => "Client Address {$i}",
                'is_verified' => true,
                'is_active' => true
            ]);
        }

        // Create sample professionals
        $professions = ['Engineer', 'Architect', 'Designer', 'Electrician', 'Plumber', 'Carpenter'];
        $professionals = [];

        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => "Professional {$i}",
                'email' => "professional{$i}@example.com",
                'password' => Hash::make('password'),
                'user_type' => 'professional',
                'phone' => "987654321{$i}",
                'address' => "Professional Address {$i}",
                'is_verified' => true,
                'is_active' => true
            ]);

            ProfessionalProfile::create([
                'user_id' => $user->id,
                'profession' => $professions[array_rand($professions)],
                'bio' => "Experienced professional with expertise in various projects.",
                'years_experience' => rand(3, 15),
                'qualifications' => json_encode(['Degree', 'Certification', 'License']),
                'languages' => json_encode(['English', 'Local Language']),
                'hourly_rate' => rand(30, 150),
                'availability' => true
            ]);

            $professionals[] = $user;
        }

        // Create store owners and stores
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Store Owner {$i}",
                'email' => "storeowner{$i}@example.com",
                'password' => Hash::make('password'),
                'user_type' => 'store_owner',
                'phone' => "555123456{$i}",
                'address' => "Store Owner Address {$i}",
                'is_verified' => true,
                'is_active' => true
            ]);

            $store = Store::create([
                'owner_id' => $user->id,
                'name' => "Construction Store {$i}",
                'email' => "store{$i}@example.com",
                'phone' => "555987654{$i}",
                'address' => "Store Address {$i}",
                'city' => "City {$i}",
                'state' => "State {$i}",
                'zip_code' => "1000{$i}",
                'latitude' => 40.7128 + (rand(-100, 100) / 1000),
                'longitude' => -74.0060 + (rand(-100, 100) / 1000),
                'business_hours' => json_encode(['Mon-Fri' => '9AM-5PM']),
                'description' => "Quality construction materials and tools",
                'is_active' => true,
                'is_verified' => true
            ]);

            // Products
            for ($j = 1; $j <= 10; $j++) {
                Product::create([
                    'store_id' => $store->id,
                    'name' => "Product {$j} - Store {$i}",
                    'slug' => "product-{$j}-store-{$i}",
                    'description' => "High quality product for construction needs",
                    'type' => ['sale', 'rent', 'both'][array_rand(['sale', 'rent', 'both'])],
                    'price_sale' => rand(100, 5000),
                    'price_rent' => rand(20, 500),
                    'rent_period' => ['daily', 'weekly', 'monthly'][array_rand(['daily', 'weekly', 'monthly'])],
                    'quantity' => rand(1, 100),
                    'specifications' => json_encode(['weight' => rand(1, 100) . 'kg', 'material' => 'Steel']),
                    'images' => json_encode(['products/sample.jpg']),
                    'is_available' => true
                ]);
            }
        }

        // Jobs
        $jobTitles = [
            'House Renovation Project',
            'Office Interior Design',
            'Electrical Wiring Installation',
            'Plumbing Repair',
            'Landscape Design',
            'Building Construction',
            'Roof Repair',
            'Painting Service'
        ];

        for ($i = 1; $i <= 20; $i++) {
            $client = $clients[array_rand($clients)];

            $job = Job::create([
                'client_id' => $client->id,
                'title' => $jobTitles[array_rand($jobTitles)],
                'description' => "Need professional services for this project.",
                'service_category' => $professions[array_rand($professions)],
                'budget_min' => rand(500, 2000),
                'budget_max' => rand(2001, 10000),
                'deadline' => now()->addDays(rand(7, 60)),
                'location' => "Project Location {$i}",
                'latitude' => 40.7128,
                'longitude' => -74.0060,
                'required_skills' => json_encode(['Skill 1', 'Skill 2']),
                'status' => 'open'
            ]);

            // Bids
            if (rand(0, 1)) {
                for ($j = 0; $j < rand(1, 5); $j++) {
                    $professional = $professionals[array_rand($professionals)];

                    Bid::create([
                        'project_job_id' => $job->id,
                        'professional_id' => $professional->id,
                        'amount' => rand($job->budget_min, $job->budget_max),
                        'proposal' => "I can complete this project efficiently.",
                        'estimated_days' => rand(5, 30),
                        'status' => 'pending'
                    ]);
                }
            }
        }

        $this->command->info('Database seeded successfully!');
    }
}