<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    //############# Query with Scopes ##########

    public function index(Request $request)
    {
        $query = Product::query()
            ->active()
            ->withRelations();

        // Search by keyword
        if ($request->filled('q')) {
            $query->search($request->q);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by price range
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->priceRange($request->min_price, $request->max_price);
        }

        // Filter by stock availability
        if ($request->filled('in_stock') && $request->in_stock) {
            $query->inStock();
        }

        // Filter by featured
        if ($request->filled('featured') && $request->featured) {
            $query->featured();
        }

        // Sorting
        $sortBy = $request->get('sort', 'latest');
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
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = \App\Services\CacheService::getCategories();

        $priceRange = Product::active()
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        return view('search.index', compact('products', 'categories', 'priceRange'));
    }

    //############# Query without Scopes ##########

    // public function index(Request $request)
    // {
    //     $query = Product::with('category', 'primaryImage')->where('is_active', true);

    //     // Search by keyword
    //     if ($request->filled('q')) {
    //         $searchTerm = $request->q;
    //         $query->where(function($q) use ($searchTerm) {
    //             $q->where('name', 'like', "%{$searchTerm}%")
    //               ->orWhere('description', 'like', "%{$searchTerm}%")
    //               ->orWhere('sku', 'like', "%{$searchTerm}%");
    //         });
    //     }

    //     // Filter by category
    //     if ($request->filled('category')) {
    //         $query->where('category_id', $request->category);
    //     }

    //     // Filter by price range
    //     if ($request->filled('min_price')) {
    //         $query->where('price', '>=', $request->min_price);
    //     }
    //     if ($request->filled('max_price')) {
    //         $query->where('price', '<=', $request->max_price);
    //     }

    //     // Filter by stock availability
    //     if ($request->filled('in_stock') && $request->in_stock) {
    //         $query->where('stock', '>', 0);
    //     }

    //     // Filter by featured
    //     if ($request->filled('featured') && $request->featured) {
    //         $query->where('is_featured', true);
    //     }

    //     // Sorting
    //     $sortBy = $request->get('sort', 'latest');
    //     switch ($sortBy) {
    //         case 'price_low':
    //             $query->orderBy('price', 'asc');
    //             break;
    //         case 'price_high':
    //             $query->orderBy('price', 'desc');
    //             break;
    //         case 'name_az':
    //             $query->orderBy('name', 'asc');
    //             break;
    //         case 'name_za':
    //             $query->orderBy('name', 'desc');
    //             break;
    //         case 'popular':
    //             $query->withCount('orderItems')
    //                   ->orderBy('order_items_count', 'desc');
    //             break;
    //         default: // latest
    //             $query->latest();
    //     }

    //     $products = $query->paginate(12)->withQueryString();
    //     $categories = Category::where('is_active', true)->get();

    //     // Get price range for filters
    //     $priceRange = Product::where('is_active', true)
    //         ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
    //         ->first();

    //     return view('search.index', compact('products', 'categories', 'priceRange'));
    // }

    public function autocomplete(Request $request)
    {
        if (!$request->filled('q')) {
            return response()->json([]);
        }

        $searchTerm = $request->q;
        
        $products = Product::where('is_active', true)
            ->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('sku', 'like', "%{$searchTerm}%");
            })
            ->with('category', 'primaryImage')
            ->limit(5)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'image' => $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : null,
                    'category' => $product->category->name,
                ];
            });

        return response()->json($products);
    }
}
