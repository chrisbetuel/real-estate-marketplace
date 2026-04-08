<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\PropertyCategory::create(['name' => 'House', 'slug' => 'house', 'sort_order' => 1]);
        \App\Models\PropertyCategory::create(['name' => 'Apartment', 'slug' => 'apartment', 'sort_order' => 2]);
        \App\Models\PropertyCategory::create(['name' => 'Condo', 'slug' => 'condo', 'sort_order' => 3]);
        \App\Models\PropertyCategory::create(['name' => 'Townhouse', 'slug' => 'townhouse', 'sort_order' => 4]);
        \App\Models\PropertyCategory::create(['name' => 'Land', 'slug' => 'land', 'sort_order' => 5]);
    }
}
