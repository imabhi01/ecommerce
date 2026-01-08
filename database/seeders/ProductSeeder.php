<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->error('Please run CategorySeeder first!');
            return;
        }

        // Electronics Products
        $electronics = $categories->where('name', 'Electronics')->first();
        if ($electronics) {
            $this->createProducts($electronics->id, [
                [
                    'name' => 'iPhone 15 Pro Max',
                    'description' => 'The latest flagship smartphone from Apple featuring A17 Pro chip, titanium design, and advanced camera system. Experience unparalleled performance and stunning photography capabilities.',
                    'price' => 1199.99,
                    'compare_price' => 1299.99,
                    'stock' => 50,
                    'sku' => 'ELEC-IPH-001',
                    'is_featured' => true,
                ],
                [
                    'name' => 'MacBook Pro 16" M3',
                    'description' => 'Professional-grade laptop with M3 chip, 16GB RAM, 512GB SSD. Perfect for creative professionals, developers, and power users who demand the best performance.',
                    'price' => 2499.99,
                    'compare_price' => 2799.99,
                    'stock' => 25,
                    'sku' => 'ELEC-MAC-001',
                    'is_featured' => true,
                ],
                [
                    'name' => 'Sony WH-1000XM5 Headphones',
                    'description' => 'Industry-leading noise cancellation, exceptional sound quality, and all-day comfort. Perfect for music lovers and frequent travelers.',
                    'price' => 399.99,
                    'compare_price' => 449.99,
                    'stock' => 100,
                    'sku' => 'ELEC-SONY-001',
                    'is_featured' => false,
                ],
                [
                    'name' => 'Samsung Galaxy S24 Ultra',
                    'description' => 'Premium Android smartphone with 200MP camera, S Pen, and powerful Snapdragon processor. The ultimate Android flagship experience.',
                    'price' => 1299.99,
                    'compare_price' => 1399.99,
                    'stock' => 40,
                    'sku' => 'ELEC-SAM-001',
                    'is_featured' => true,
                ],
                [
                    'name' => 'iPad Air 11" M2',
                    'description' => 'Versatile tablet powered by M2 chip, perfect for creativity, productivity, and entertainment. Includes Apple Pencil support.',
                    'price' => 799.99,
                    'compare_price' => null,
                    'stock' => 60,
                    'sku' => 'ELEC-IPAD-001',
                    'is_featured' => false,
                ],
            ]);
        }

        // Clothing Products
        $clothing = $categories->where('name', 'Clothing')->first();
        if ($clothing) {
            $this->createProducts($clothing->id, [
                [
                    'name' => 'Premium Cotton T-Shirt',
                    'description' => 'Comfortable 100% organic cotton t-shirt, perfect for everyday wear. Available in multiple colors and sizes. Breathable and durable.',
                    'price' => 29.99,
                    'compare_price' => 39.99,
                    'stock' => 200,
                    'sku' => 'CLO-TSHIRT-001',
                    'is_featured' => false,
                ],
                [
                    'name' => 'Designer Denim Jeans',
                    'description' => 'Premium quality denim jeans with modern fit and style. Crafted from durable denim with comfortable stretch. Perfect for any occasion.',
                    'price' => 89.99,
                    'compare_price' => 129.99,
                    'stock' => 150,
                    'sku' => 'CLO-JEANS-001',
                    'is_featured' => true,
                ],
                [
                    'name' => 'Winter Wool Coat',
                    'description' => 'Elegant wool blend coat for cold weather. Features premium lining, deep pockets, and timeless design. Stay warm and stylish.',
                    'price' => 199.99,
                    'compare_price' => 279.99,
                    'stock' => 50,
                    'sku' => 'CLO-COAT-001',
                    'is_featured' => true,
                ],
                [
                    'name' => 'Sports Performance Hoodie',
                    'description' => 'Moisture-wicking athletic hoodie with breathable fabric. Perfect for workouts, running, or casual wear. Quick-dry technology.',
                    'price' => 59.99,
                    'compare_price' => null,
                    'stock' => 120,
                    'sku' => 'CLO-HOOD-001',
                    'is_featured' => false,
                ],
            ]);
        }

        // Books Products
        $books = $categories->where('name', 'Books')->first();
        if ($books) {
            $this->createProducts($books->id, [
                [
                    'name' => 'The Psychology of Money',
                    'description' => 'Timeless lessons on wealth, greed, and happiness by Morgan Housel. Learn how to build wealth and make better financial decisions.',
                    'price' => 16.99,
                    'compare_price' => 24.99,
                    'stock' => 300,
                    'sku' => 'BOOK-PSY-001',
                    'is_featured' => true,
                ],
                [
                    'name' => 'Atomic Habits',
                    'description' => 'An easy and proven way to build good habits and break bad ones. James Clear\'s groundbreaking book on behavior change.',
                    'price' => 14.99,
                    'compare_price' => 19.99,
                    'stock' => 250,
                    'sku' => 'BOOK-HAB-001',
                    'is_featured' => true,
                ],
                [
                    'name' => 'Clean Code',
                    'description' => 'A handbook of agile software craftsmanship by Robert C. Martin. Essential reading for every programmer and software engineer.',
                    'price' => 44.99,
                    'compare_price' => null,
                    'stock' => 100,
                    'sku' => 'BOOK-CODE-001',
                    'is_featured' => false,
                ],
            ]);
        }

        // Home & Kitchen Products
        $homeKitchen = $categories->where('name', 'Home & Kitchen')->first();
        if ($homeKitchen) {
            $this->createProducts($homeKitchen->id, [
                [
                    'name' => 'Smart Coffee Maker',
                    'description' => 'WiFi-enabled programmable coffee maker with mobile app control. Wake up to freshly brewed coffee every morning.',
                    'price' => 129.99,
                    'compare_price' => 169.99,
                    'stock' => 75,
                    'sku' => 'HOME-COFFEE-001',
                    'is_featured' => true,
                ],
                [
                    'name' => 'Chef\'s Knife Set',
                    'description' => 'Professional 8-piece stainless steel knife set with wooden block. Essential tools for every home chef.',
                    'price' => 149.99,
                    'compare_price' => 199.99,
                    'stock' => 90,
                    'sku' => 'HOME-KNIFE-001',
                    'is_featured' => false,
                ],
                [
                    'name' => 'Air Fryer XL',
                    'description' => '6-quart digital air fryer with 8 preset cooking functions. Cook healthier meals with little to no oil.',
                    'price' => 99.99,
                    'compare_price' => 139.99,
                    'stock' => 110,
                    'sku' => 'HOME-FRYER-001',
                    'is_featured' => true,
                ],
            ]);
        }

        // Sports & Outdoors Products
        $sports = $categories->where('name', 'Sports & Outdoors')->first();
        if ($sports) {
            $this->createProducts($sports->id, [
                [
                    'name' => 'Yoga Mat Premium',
                    'description' => 'Extra thick non-slip yoga mat with carrying strap. Perfect for yoga, pilates, and floor exercises. Eco-friendly materials.',
                    'price' => 34.99,
                    'compare_price' => 49.99,
                    'stock' => 180,
                    'sku' => 'SPORT-YOGA-001',
                    'is_featured' => false,
                ],
                [
                    'name' => 'Adjustable Dumbbell Set',
                    'description' => 'Space-saving adjustable dumbbells, 5-52.5 lbs per hand. Perfect for home gym and strength training.',
                    'price' => 299.99,
                    'compare_price' => 399.99,
                    'stock' => 45,
                    'sku' => 'SPORT-DUMB-001',
                    'is_featured' => true,
                ],
                [
                    'name' => 'Camping Tent 4-Person',
                    'description' => 'Waterproof family camping tent with easy setup. Includes rainfly, stakes, and carry bag. Perfect for weekend adventures.',
                    'price' => 159.99,
                    'compare_price' => null,
                    'stock' => 65,
                    'sku' => 'SPORT-TENT-001',
                    'is_featured' => false,
                ],
            ]);
        }

        // Beauty & Personal Care Products
        $beauty = $categories->where('name', 'Beauty & Personal Care')->first();
        if ($beauty) {
            $this->createProducts($beauty->id, [
                [
                    'name' => 'Vitamin C Serum',
                    'description' => 'Anti-aging facial serum with 20% Vitamin C, hyaluronic acid, and vitamin E. Brightens and evens skin tone.',
                    'price' => 24.99,
                    'compare_price' => 34.99,
                    'stock' => 200,
                    'sku' => 'BEAUTY-SERUM-001',
                    'is_featured' => true,
                ],
                [
                    'name' => 'Hair Dryer Professional',
                    'description' => 'Ionic salon-quality hair dryer with multiple heat and speed settings. Includes concentrator and diffuser attachments.',
                    'price' => 79.99,
                    'compare_price' => 119.99,
                    'stock' => 85,
                    'sku' => 'BEAUTY-DRYER-001',
                    'is_featured' => false,
                ],
            ]);
        }

        // Toys & Games Products
        $toys = $categories->where('name', 'Toys & Games')->first();
        if ($toys) {
            $this->createProducts($toys->id, [
                [
                    'name' => 'LEGO Creator 3-in-1',
                    'description' => 'Build and rebuild 3 different models with this creative LEGO set. Encourages imagination and fine motor skills.',
                    'price' => 49.99,
                    'compare_price' => null,
                    'stock' => 130,
                    'sku' => 'TOY-LEGO-001',
                    'is_featured' => false,
                ],
                [
                    'name' => 'Board Game Collection',
                    'description' => 'Family game night bundle with 5 classic board games. Perfect for ages 8 and up. Hours of entertainment.',
                    'price' => 39.99,
                    'compare_price' => 59.99,
                    'stock' => 95,
                    'sku' => 'TOY-BOARD-001',
                    'is_featured' => true,
                ],
            ]);
        }

        // Automotive Products
        $automotive = $categories->where('name', 'Automotive')->first();
        if ($automotive) {
            $this->createProducts($automotive->id, [
                [
                    'name' => 'Dash Camera 4K',
                    'description' => '4K Ultra HD dash cam with night vision, parking mode, and GPS. Protect yourself with reliable video evidence.',
                    'price' => 149.99,
                    'compare_price' => 199.99,
                    'stock' => 70,
                    'sku' => 'AUTO-DASH-001',
                    'is_featured' => true,
                ],
                [
                    'name' => 'Car Vacuum Cleaner',
                    'description' => 'Powerful cordless handheld vacuum for car interiors. Includes multiple attachments and rechargeable battery.',
                    'price' => 59.99,
                    'compare_price' => null,
                    'stock' => 120,
                    'sku' => 'AUTO-VAC-001',
                    'is_featured' => false,
                ],
            ]);
        }

        $this->command->info('Products created successfully!');
    }

    private function createProducts($categoryId, $products)
    {
        foreach ($products as $productData) {
            Product::create([
                'category_id' => $categoryId,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'compare_price' => $productData['compare_price'],
                'stock' => $productData['stock'],
                'sku' => $productData['sku'],
                'is_active' => true,
                'is_featured' => $productData['is_featured'],
            ]);
        }
    }
}
