<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogPost; // Changed from Blog to BlogPost
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = User::first();

        if (!$author) {
            $this->command->warn('No users found. Creating a dummy user...');
            $author = User::factory()->create();
        }

        $blogs = [
            [
                'title' => 'Top Web Development Trends in 2026',
                'category' => 'Technology',
                'excerpt' => 'Discover the latest web development trends shaping the future of modern websites.',
                'content' => '<p>Web development is evolving rapidly with AI-driven tools, serverless architecture, and modern frameworks like Laravel and Next.js.</p>',
                'is_featured' => true,
            ],
            [
                'title' => 'Best AI Tools to Earn Money Online',
                'category' => 'AI & Tools',
                'excerpt' => 'A curated list of AI tools that can help you generate passive income online.',
                'content' => '<p>AI tools such as ChatGPT, Midjourney, and automation platforms are transforming online income opportunities.</p>',
                'is_featured' => false,
            ],
            [
                'title' => 'Top Digital Gadgets You Must Own',
                'category' => 'Digital Gadgets',
                'excerpt' => 'These smart gadgets can improve your productivity and lifestyle.',
                'content' => '<p>From smartwatches to noise-canceling headphones, digital gadgets are becoming smarter and more affordable.</p>',
                'is_featured' => false,
            ],
            [
                'title' => 'Exploring Street Food Cultures Around the World',
                'category' => 'Food & Cuisine',
                'excerpt' => 'A delicious journey through famous street foods across different countries.',
                'content' => '<p>Street food represents the heart of a culture, offering authentic flavors at affordable prices.</p>',
                'is_featured' => false,
            ],
            [
                'title' => 'How Travel Blogging Can Make You Money',
                'category' => 'Travel',
                'excerpt' => 'Learn how travel bloggers monetize their content using affiliates and digital products.',
                'content' => '<p>Travel blogging combines passion with income through sponsorships, affiliate marketing, and digital sales.</p>',
                'is_featured' => false,
            ],
            [
                'title' => 'Building a Digital Lifestyle as a Developer',
                'category' => 'Lifestyle',
                'excerpt' => 'How web developers can build location-independent digital careers.',
                'content' => '<p>With freelancing, blogging, and digital products, developers can achieve financial freedom.</p>',
                'is_featured' => false,
            ],
        ];

        foreach ($blogs as $item) {
            $category = BlogCategory::where('name', $item['category'])->first();

            if (!$category) {
                $this->command->warn("Category '{$item['category']}' not found. Skipping post: {$item['title']}");
                continue;
            }

            BlogPost::create([
                'blog_category_id' => $category->id,
                'user_id'          => $author->id,
                'title'            => $item['title'],
                'slug'             => Str::slug($item['title']),
                'excerpt'          => $item['excerpt'],
                'content'          => $item['content'],
                'featured_image'   => 'blog/seeds/default.jpg', // ← FIXED: local path
                'is_featured'      => $item['is_featured'],
                'allow_comments'   => true,      // ← ADDED
                'status'           => 'published', // ← CHANGED from is_published
                'published_at'     => now(),
                'views'            => rand(20, 500),
            ]);
        }
    }
}