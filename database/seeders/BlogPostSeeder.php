<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = BlogCategory::all();
        $user = User::first() ?: User::factory()->create();

        if ($categories->isEmpty()) {
            $this->command->info("No categories found, run BlogCategorySeeder first.");
            return;
        }

        $titles = [
            'The Ultimate Guide to {{category}}',
            'Top Tips for Successful {{category}}',
            '{{category}} Trends You Need to Know',
            'How {{category}} Is Changing the World',
            'Beginner’s Guide to {{category}}',
        ];

        foreach ($categories as $category) {
            for ($i = 0; $i < 5; $i++) {
                $title = str_replace('{{category}}', $category->name, $titles[array_rand($titles)]);
                $slug = Str::slug($title . '-' . time() . '-' . rand(1, 9999));

                $featuredImage = [
                    'https://images.pexels.com/photos/' . rand(1000, 9999) . '/pexels-photo.jpg'
                ];

                $post = BlogPost::create([
                    'blog_category_id' => $category->id,
                    'user_id' => $user->id,
                    'title' => $title,
                    'slug' => $slug,
                    'excerpt' => "A short intro about {$title}.",
                    'content' => "<p>This is a dummy blog content about {$title}. Use this to design your blog layout.</p>",
                    'featured_image' => $featuredImage[0],
                    'meta_title' => $title,
                    'meta_description' => "Learn more about {$title}.",
                    'meta_keywords' => strtolower($category->name . ', blog'),
                    'is_published' => true,
                    'published_at' => now(),
                ]);

                $this->call([
                    BlogPostImagesSeeder::class
                ]);
            }
        }
    }
}
