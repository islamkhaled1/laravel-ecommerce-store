<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Phones',
            'Laptops',
            'Accessories',
            'Cameras',
            'Clothes',
            'Gaming',
            'Tablets',
        ];

        foreach ($categories as $cat) {
      
            $cleanName = ucfirst(trim(strtolower($cat)));

            Category::firstOrCreate(['name' => $cleanName]);
        }
    }
}
