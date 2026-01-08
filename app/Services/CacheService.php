<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Product;
use App\Models\Category;

class CacheService
{
    const CACHE_TTL = 3600; // 1 hour

    public static function getProduct($slug)
    {
        return Cache::remember(
            "product_{$slug}",
            self::CACHE_TTL,
            fn() => Product::with(['images', 'category', 'approvedReviews.user'])
                ->where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail()
        );
    }

    public static function getCategories()
    {
        return Cache::remember(
            'active_categories',
            self::CACHE_TTL,
            fn() => Category::where('is_active', true)
                ->withCount('products')
                ->orderBy('name')
                ->get()
        );
    }

    public static function getFeaturedProducts($limit = 8)
    {
        return Cache::remember(
            "featured_products_{$limit}",
            self::CACHE_TTL,
            fn() => Product::with(['primaryImage', 'category'])
                ->where('is_active', true)
                ->where('is_featured', true)
                ->inRandomOrder()
                ->limit($limit)
                ->get()
        );
    }

    public static function getPopularProducts($limit = 8)
    {
        return Cache::remember(
            "popular_products_{$limit}",
            self::CACHE_TTL,
            fn() => Product::with(['primaryImage', 'category'])
                ->withCount('orderItems')
                ->where('is_active', true)
                ->orderBy('order_items_count', 'desc')
                ->limit($limit)
                ->get()
        );
    }

    public static function clearProductCache($product)
    {
        Cache::forget("product_{$product->slug}");
        Cache::forget('featured_products_8');
        Cache::forget('popular_products_8');
    }

    public static function clearCategoryCache($category = null)
    {
        Cache::forget('active_categories');
        if ($category) {
            Cache::forget("category_{$category->slug}");
        }
    }
}