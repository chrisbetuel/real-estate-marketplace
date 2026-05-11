<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AddProductImagesSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();
        
        foreach ($products as $product) {
            // Option 1: Add placeholder images based on category
            $categoryImages = [
                'Building Materials' => 'https://picsum.photos/id/104/400/300',
                'Tools' => 'https://picsum.photos/id/120/400/300',
                'Equipment' => 'https://picsum.photos/id/96/400/300',
                'Hardware' => 'https://picsum.photos/id/88/400/300',
            ];
            
            $imageUrl = $categoryImages[$product->category] ?? 'https://picsum.photos/id/20/400/300';
            
            // Update the images field with JSON data
            $product->update([
                'images' => json_encode([$imageUrl])
            ]);
            
            $this->command->info("Added image to product: {$product->name}");
        }
    }
}