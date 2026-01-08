<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Latest gadgets, smartphones, laptops, and electronic accessories for your digital lifestyle.',
                'is_active' => true,
            ],
            [
                'name' => 'Clothing',
                'description' => 'Trendy fashion wear for men, women, and kids. Stay stylish with our curated collection.',
                'is_active' => true,
            ],
            [
                'name' => 'Books',
                'description' => 'Explore a vast collection of fiction, non-fiction, educational books, and bestsellers.',
                'is_active' => true,
            ],
            [
                'name' => 'Home & Kitchen',
                'description' => 'Everything you need for your home - furniture, appliances, cookware, and decor.',
                'is_active' => true,
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Gear up for your adventures with sports equipment, outdoor gear, and fitness products.',
                'is_active' => true,
            ],
            [
                'name' => 'Beauty & Personal Care',
                'description' => 'Premium beauty products, skincare, haircare, and wellness essentials.',
                'is_active' => true,
            ],
            [
                'name' => 'Toys & Games',
                'description' => 'Fun and educational toys, board games, puzzles, and entertainment for all ages.',
                'is_active' => true,
            ],
            [
                'name' => 'Automotive',
                'description' => 'Car accessories, tools, parts, and maintenance products for your vehicle.',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => $category['is_active'],
            ]);
        }

        $this->command->info('Categories created successfully!');
    }
}
