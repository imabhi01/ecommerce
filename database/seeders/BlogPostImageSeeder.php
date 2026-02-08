<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogPostImage;
use App\Models\BlogPost;

class BlogPostImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $posts = BlogPost::all();

        // Placeholder images (you can add real ones to storage/app/public/blog/seeds/)
        $placeholders = [
            'blog/seeds/placeholder1.jpg',
            'blog/seeds/placeholder2.jpg',
            'blog/seeds/placeholder3.jpg',
            'blog/seeds/placeholder4.jpg',
            'blog/seeds/placeholder5.webp',
        ];

        foreach ($posts as $post) {
            for ($i = 1; $i <= rand(2, 5); $i++) {
                BlogPostImage::create([
                    'blog_post_id' => $post->id,
                    'image_path'   => $placeholders[array_rand($placeholders)], // ← FIXED: local path
                    'alt_text'     => "Image {$i} for {$post->title}",          // ← ADDED
                    'sort_order'   => $i,
                ]);
            }
        }
    }
}