<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            'Technology',
            'Travel',
            'Food & Drink',
            'Lifestyle',
            'Business',
            'Health & Wellness',
        ];

        foreach ($categories as $name) {
            BlogCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "All about {$name} topics and insights.",
                'image' => 'https://images.pexels.com/photos/' . rand(2000, 9999) . '/pexels-photo.jpg',
                'is_active' => true,
            ]);
        }
    }
}
