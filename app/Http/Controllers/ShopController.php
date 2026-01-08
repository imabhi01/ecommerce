<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class ShopController extends Controller
{
    // public function index()
    // {
    //     $products = Product::with('primaryImage', 'category')
    //         ->where('is_active', true)
    //         ->latest()
    //         ->paginate(12);
        
    //     $categories = Category::where('is_active', true)->get();
        
    //     return view('shop.index', compact('products', 'categories'));
    // }
    
    //With Caching
     public function index()
    {
        // Cache categories for 1 hour
        $categories = Cache::remember('active_categories', 3600, function () {
            return Category::where('is_active', true)
                ->withCount('products')
                ->get();
        });

        // Eager load relationships
        $products = Product::with(['primaryImage', 'category'])
            ->where('is_active', true)
            ->latest()
            ->paginate(12);
        
        return view('shop.index', compact('products', 'categories'));
    }

    // public function show($slug)
    // {
    //     $product = Product::with('images', 'category')
    //         ->where('slug', $slug)
    //         ->where('is_active', true)
    //         ->firstOrFail();
        
    //     $relatedProducts = Product::with('primaryImage')
    //         ->where('category_id', $product->category_id)
    //         ->where('id', '!=', $product->id)
    //         ->where('is_active', true)
    //         ->limit(4)
    //         ->get();
        
    //     return view('shop.show', compact('product', 'relatedProducts'));
    // }

    public function show($slug)
    {
        // Cache individual product for 30 minutes
        $product = Cache::remember("product_{$slug}", 1800, function () use ($slug) {
            return Product::with(['images', 'category'])
                ->where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();
        });

        // Eager load related products
        $relatedProducts = Product::with('primaryImage')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Eager load reviews with user
        $product->load(['approvedReviews' => function($query) {
            $query->with('user')->latest();
        }]);
        
        return view('shop.show', compact('product', 'relatedProducts'));
    }

    public function category($slug)
    {
        $category = Cache::remember("category_{$slug}", 1800, function () use ($slug) {
            return Category::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();
        });
        
        $query = Product::with('primaryImage')
            ->where('category_id', $category->id)
            ->where('is_active', true);

        // Sorting
        $sortBy = request()->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_az':
                $query->orderBy('name', 'asc');
                break;
            case 'name_za':
                $query->orderBy('name', 'desc');
                break;
            case 'popular':
                $query->withCount('orderItems')
                    ->orderBy('order_items_count', 'desc');
                break;
            default: // latest
                $query->latest();
        }

        $products = $query->paginate(12);
        
        return view('shop.category', compact('category', 'products'));
    }

    // public function category($slug)
    // {
    //     $category = Category::where('slug', $slug)->firstOrFail();
        
    //     $products = Product::with('primaryImage')
    //         ->where('category_id', $category->id)
    //         ->where('is_active', true)
    //         ->paginate(12);
        
    //     return view('shop.category', compact('category', 'products'));
    // }

}
