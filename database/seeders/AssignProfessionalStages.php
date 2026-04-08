<?php
// database/seeders/AssignProfessionalStages.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfessionalProfile;
use App\Models\User;

class AssignProfessionalStages extends Seeder
{
    public function run()
    {
        $stageMapping = [
            'Architect' => 1,
            'Structural Engineer' => 1,
            'Civil Engineer' => 1,
            'Interior Designer' => 1,
            'Urban Planner' => 1,
            'Quantity Surveyor' => 1,
            'Real Estate Lawyer' => 2,
            'Land Surveyor' => 2,
            'Property Valuer' => 2,
            'Environmental Consultant' => 2,
            'Investment Advisor' => 3,
            'Financial Analyst' => 3,
            'Mortgage Specialist' => 3,
            'Building Contractor' => 4,
            'Site Engineer' => 4,
            'Project Manager' => 4,
            'Mason' => 4,
            'Carpenter' => 4,
            'Steel Fixer' => 4,
            'Electrician' => 5,
            'Plumber' => 5,
            'HVAC Technician' => 5,
            'Solar Technician' => 5,
            'Fire Safety Technician' => 5,
            'Painter' => 6,
            'Tiler' => 6,
            'Gypsum Specialist' => 6,
            'Glass Installer' => 6,
            'Cabinet Installer' => 6,
            'Flooring Specialist' => 6,
            'Property Manager' => 7,
            'Facility Manager' => 7,
            'Maintenance Technician' => 7,
            'Cleaning Services' => 7,
            'Security Services' => 7,
            'Building Inspector' => 8,
            'Clerk of Works' => 8,
            'Quality Assurance Engineer' => 8,
            'Renovation Specialist' => 9,
            'Legal Transfer Specialist' => 9,
        ];

        $profiles = ProfessionalProfile::all();
        
        foreach ($profiles as $profile) {
            if (isset($stageMapping[$profile->profession])) {
                $profile->stage = $stageMapping[$profile->profession];
                $profile->save();
                echo "Updated: {$profile->profession} -> Stage {$profile->stage}\n";
            }
        }
    }
}