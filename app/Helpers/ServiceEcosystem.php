<?php
// app/Helpers/ServiceEcosystem.php

namespace App\Helpers;

class ServiceEcosystem
{
    public static function getStages()
    {
        return [
            1 => [
                'name' => 'Planning & Design',
                'icon' => 'fas fa-drafting-compass',
                'color' => '#C9A53B',
                'substages' => [
                    'planning' => [
                        'name' => 'Planning Stage',
                        'professions' => ['Real Estate Consultant', 'Property Advisor', 'Land Surveyor', 'Urban Planner', 'Town Planner', 'Legal Advisor (Property Lawyer)', 'Valuer / Property Appraiser', 'Project Manager', 'Environmental Consultant']
                    ],
                    'designing' => [
                        'name' => 'Designing Stage',
                        'professions' => ['Architect', 'Interior Designer', 'Structural Engineer', 'Electrical Engineer', 'Mechanical Engineer', 'Quantity Surveyor', '3D Visualizer', 'CAD Designer']
                    ]
                ],
                'description' => 'Turn your vision into actionable plans with expert design and engineering',
            ],
            2 => [
                'name' => 'Legal & Compliance',
                'icon' => 'fas fa-gavel',
                'color' => '#C9A53B',
                'professions' => ['Real Estate Lawyer', 'Land Surveyor', 'Property Valuer', 'Environmental Consultant'],
                'description' => 'Ensure your project meets all legal requirements and regulations',
            ],
            3 => [
                'name' => 'Finance & Investment',
                'icon' => 'fas fa-chart-line',
                'color' => '#C9A53B',
                'professions' => ['Investment Advisor', 'Financial Analyst', 'Mortgage Specialist'],
                'description' => 'Secure funding and optimize your investment strategy',
            ],
            4 => [
                'name' => 'Construction & Execution',
                'icon' => 'fas fa-hard-hat',
                'color' => '#C9A53B',
                'professions' => ['Building Contractor', 'Site Engineer', 'Project Manager', 'Mason', 'Carpenter', 'Steel Fixer'],
                'description' => 'Professional construction services to bring your project to life',
            ],
            5 => [
                'name' => 'Technical Installation',
                'icon' => 'fas fa-bolt',
                'color' => '#C9A53B',
                'professions' => ['Electrician', 'Plumber', 'HVAC Technician', 'Solar Technician', 'Fire Safety Technician'],
                'description' => 'Install essential systems for a fully functional property',
            ],
            6 => [
                'name' => 'Finishing & Fit-Out',
                'icon' => 'fas fa-paint-roller',
                'color' => '#C9A53B',
                'professions' => ['Painter', 'Tiler', 'Gypsum Specialist', 'Glass Installer', 'Cabinet Installer', 'Flooring Specialist'],
                'description' => 'Add the final touches that make your property shine',
            ],
            7 => [
                'name' => 'Property Management',
                'icon' => 'fas fa-building',
                'color' => '#C9A53B',
                'professions' => ['Property Manager', 'Facility Manager', 'Maintenance Technician', 'Cleaning Services', 'Security Services'],
                'description' => 'Maintain and operate your property efficiently',
            ],
            8 => [
                'name' => 'Inspection & Quality',
                'icon' => 'fas fa-clipboard-list',
                'color' => '#C9A53B',
                'professions' => ['Building Inspector', 'Clerk of Works', 'Quality Assurance Engineer'],
                'description' => 'Ensure quality standards and accountability throughout',
            ],
            9 => [
                'name' => 'Renovation & Exit',
                'icon' => 'fas fa-home',
                'color' => '#C9A53B',
                'professions' => ['Renovation Specialist', 'Property Valuer', 'Legal Transfer Specialist'],
                'description' => 'Upgrade, value, or successfully exit your property',
            ],
        ];
    }

    public static function getStageName($stage)
    {
        $stages = self::getStages();
        return $stages[$stage]['name'] ?? 'Unknown';
    }

    public static function getStageIcon($stage)
    {
        $stages = self::getStages();
        return $stages[$stage]['icon'] ?? 'fas fa-circle';
    }

    public static function getProfessionsByStage($stage)
    {
        $stages = self::getStages();
        return $stages[$stage]['professions'] ?? [];
    }

    public static function getAllProfessions()
    {
        $allProfessions = [];
        foreach (self::getStages() as $stage) {
            $allProfessions = array_merge($allProfessions, $stage['professions']);
        }
        return $allProfessions;
    }
}