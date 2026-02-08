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
        $user = User::first();

        if (!$user) {
            $this->command->warn('No users found. Creating a test user...');
            $user = User::factory()->create();
        }

        if ($categories->isEmpty()) {
            $this->command->error("No categories found. Please run BlogCategorySeeder first.");
            return;
        }

        $titles = [
            'The Ultimate Guide to {{category}}',
            'Top Tips for Successful {{category}}',
            '{{category}} Trends You Need to Know',
            'How {{category}} Is Changing the World',
            'Beginner\'s Guide to {{category}}',
            'Master {{category}} in 30 Days',
            'Why {{category}} Matters in 2026',
            '10 Things About {{category}} You Should Know',
        ];

        // Placeholder featured images (these will be in storage/app/public/blog/seeds/)
        $featuredImages = [
            'blog/seeds/featured1.jpg',
            'blog/seeds/featured2.jpg',
            'blog/seeds/featured3.jpg',
        ];

        $this->command->info('Creating blog posts...');

        foreach ($categories as $category) {
            // Create 3-5 posts per category
            $postCount = rand(3, 5);
            
            for ($i = 0; $i < $postCount; $i++) {
                $title = str_replace('{{category}}', $category->name, $titles[array_rand($titles)]);
                
                // Make slug unique by adding timestamp
                $slug = Str::slug($title) . '-' . now()->timestamp . rand(100, 999);

                $post = BlogPost::create([
                    'blog_category_id' => $category->id,
                    'user_id'          => $user->id,
                    'title'            => $title,
                    'slug'             => $slug,
                    'excerpt'          => "This is a brief introduction to {$title}. Learn the essential concepts and best practices in this comprehensive guide.",
                    'content'          => $this->generateContent($title, $category->name),
                    'featured_image'   => $featuredImages[array_rand($featuredImages)],
                    'meta_title'       => $title,
                    'meta_description' => "Learn everything about {$title}. Expert tips and insights.",
                    'meta_keywords'    => strtolower($category->name . ', blog, tutorial, guide'),
                    'status'           => $i === 0 ? 'published' : (rand(0, 2) === 0 ? 'draft' : 'published'),
                    'is_featured'      => $i === 0 && rand(0, 1) === 1, // Featured first post sometimes
                    'allow_comments'   => true,
                    'published_at'     => $i === 0 ? now() : now()->subDays(rand(1, 30)),
                    'views'            => rand(10, 500),
                ]);

                $this->command->info("  ✓ Created: {$post->title}");
            }
        }

        $this->command->info('Blog posts created successfully!');
    }

    private function generateContent($title, $categoryName)
    {
        return "
            <h2>Introduction</h2>
            <p>Welcome to this comprehensive guide about {$title}. In this article, we'll explore the key aspects of {$categoryName} and provide you with actionable insights.</p>
            
            <h2>Why This Matters</h2>
            <p>Understanding {$categoryName} is crucial in today's fast-paced digital world. Whether you're a beginner or an expert, there's always something new to learn.</p>
            
            <h2>Key Points to Remember</h2>
            <ul>
                <li>Stay updated with the latest trends in {$categoryName}</li>
                <li>Practice consistently to improve your skills</li>
                <li>Learn from experts and community members</li>
                <li>Apply what you learn in real-world projects</li>
            </ul>
            
            <h2>Getting Started</h2>
            <p>The best way to begin is to take one step at a time. Don't try to learn everything at once. Focus on the fundamentals first.</p>
            
            <h2>Conclusion</h2>
            <p>We hope this guide on {$title} has been helpful. Remember, the key to success is consistent practice and continuous learning. Feel free to share your thoughts in the comments below!</p>
        ";
    }
}
