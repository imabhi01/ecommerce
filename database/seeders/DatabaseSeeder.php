<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;    
use App\Models\Product;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\BlogCategorySeeder;
use Database\Seeders\BlogPostSeeder;
use Database\Seeders\BlogPostImageSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
            BlogPostImageSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('Database seeding completed successfully!');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('Admin: admin@modernshop.com | password');
        $this->command->info('User: john@example.com | password');
        $this->command->info('');
    }
}
