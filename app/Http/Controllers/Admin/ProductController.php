<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\ImageService;
use App\Services\CacheService;
use App\Helpers\SlugHelper;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'primaryImage');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120' // 5MB max
        ]);

        // $validated['slug'] = Str::slug($validated['name']);
        $validated['slug'] = SlugHelper::unique($request->name); // Ensure unique slug generation (duplicate names are allowed but generates unique slugs)
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $product = Product::create($validated);

        // Handle image uploads with optimization
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = ImageService::optimize($image, 'products');
                
                // Create thumbnail
                ImageService::createThumbnail($path, 300, 300);
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'sort_order' => $index
                ]);
            }
        }

        // Clear cache
        CacheService::clearProductCache($product);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);


        // Regenerate slug ONLY if name changed
        if ($product->name !== $validated['name']) {
            $validated['slug'] = SlugHelper::unique($validated['name']);
        }

        // Update product fields
        $product->update(collect($validated)->except('images')->toArray());

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $sortOrder = $product->images()->max('sort_order') + 1;
            foreach ($request->file('images') as $image) {
                $path = ImageService::optimize($image, 'products');
                ImageService::createThumbnail($path, 300, 300);
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'sort_order' => $sortOrder++
                ]);
            }
        }

        // Clear cache
        CacheService::clearProductCache($product);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Delete associated images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function deleteImage($imageId)
    {
        // $image = ProductImage::findOrFail($imageId);
        // Storage::disk('public')->delete($image->image_path);
        // $image->delete();

        // return back()->with('success', 'Image deleted successfully!');

         $image = ProductImage::findOrFail($imageId);
        
        // Delete image files
        ImageService::delete($image->image_path);
        
        $product = $image->product;
        $image->delete();

        // Clear cache
        CacheService::clearProductCache($product);

        return back()->with('success', 'Image deleted successfully!');
    }
}
