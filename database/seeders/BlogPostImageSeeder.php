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

        foreach ($posts as $post) {
            for ($i = 1; $i <= rand(2, 5); $i++) {
                BlogPostImage::create([
                    'blog_post_id' => $post->id,
                    'image_path' => 'https://images.pexels.com/photos/' . rand(1000, 9999) . '/pexels-photo.jpg',
                    'sort_order' => $i,
                ]);
            }
        }
    }
}
