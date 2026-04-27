<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProfessionalProfile;
use App\Helpers\ServiceEcosystem;

class ProfessionalDemoSeeder extends Seeder
{
    public function run()
    {
        $stages = ServiceEcosystem::getStages();
        $professions = [];
        $allProfessions = ServiceEcosystem::getAllProfessions();
        $professions = array_unique($allProfessions);
        $professions = array_unique($professions);

        foreach ($professions as $profession) {
            $email = strtolower($profession) . '@demo.com';
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => ucfirst($profession) . ' Expert',
                    'email_verified_at' => now(),
                    'password' => bcrypt('password'),
                    'user_type' => 'professional',
                    'phone' => '123-456-7890',
                    'profile_image' => null,
                    'is_verified' => true,
                    'is_active' => true,
                ]
            );

            $stageNum = rand(1, 9);
            ProfessionalProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'profession' => $profession,
                    'years_experience' => rand(3, 20),
                    'hourly_rate' => rand(50, 200),
                    'bio' => 'Experienced ' . $profession . ' with ' . rand(50, 200) . '+ projects completed.',
                    'latitude' => rand(-6.8, -6.7) + (rand(0,100)/10000),
                    'longitude' => rand(39.1, 39.3) + (rand(0,100)/10000),
                ]
            );
            echo "Ensured {$profession} (stage {$stageNum})\n";
        }

        echo "Created/Updated " . count($professions) . " demo professionals.\n";
    }
}
