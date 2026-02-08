<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoLibraryController extends Controller
{
    /**
     * GET /admin/blog/photo-library
     *
     * Returns a paginated JSON list of ALL images in the library.
     * The modal fetches this on open and on every page change.
     */
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 24);

        $images = BlogPostImage::latest()
            ->paginate($perPage)
            ->through(fn($image) => [
                'id'        => $image->id,
                'url'       => $image->getUrl(),
                'alt_text'  => $image->alt_text,
                'post_id'   => $image->blog_post_id,   // null = unattached library image
                'created'   => $image->created_at->format('M d, Y'),
            ]);

        return response()->json($images);
    }

    /**
     * POST /admin/blog/photo-library/upload
     *
     * Accepts one or more images via multipart form.
     * Images are stored without a blog_post_id — they live in the
     * library until explicitly attached to a post.
     */
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'images'   => 'required|array|min:1',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);

            $uploaded = [];

            foreach ($request->file('images') as $file) {
                $path = $file->store('blog/library', 'public');

                $image = BlogPostImage::create([
                    'blog_post_id' => null,
                    'image_path'   => $path,
                    'alt_text'     => $file->getClientOriginalName(),
                    'sort_order'   => 0,
                ]);

                $uploaded[] = [
                    'id'  => $image->id,
                    'url' => $image->getUrl(),
                    'alt' => $image->alt_text,
                ];
            }

            return response()->json([
                'success'  => true,
                'uploaded' => $uploaded,
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Photo library upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * PUT /admin/blog/photo-library/{id}
     *
     * Updates the alt_text for an image. Handy for accessibility
     * and for labelling images after upload.
     */
    public function updateAlt(Request $request, BlogPostImage $image)
    {
        $request->validate([
            'alt_text' => 'nullable|string|max:255',
        ]);

        $image->update(['alt_text' => $request->alt_text]);

        return response()->json(['success' => true, 'alt_text' => $image->alt_text]);
    }

    /**
     * DELETE /admin/blog/photo-library/{id}
     *
     * Removes the image file from disk and the database row.
     * Does NOT delete images that are currently attached to a post
     * — the user must remove them from the post first.
     */
    public function destroy(BlogPostImage $image)
    {
        if ($image->blog_post_id !== null) {
            return response()->json([
                'success' => false,
                'message' => 'This image is attached to a blog post. Remove it from the post first.',
            ], 422);
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }

    /**
     * POST /admin/blog/photo-library/upload-single
     *
     * Used by TinyMCE's images_upload_handler.
     * Accepts exactly one image, stores it, returns { url }.
     */
    public function uploadSingle(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $file = $request->file('image');
        $path = $file->store('blog/inline', 'public');

        BlogPostImage::create([
            'blog_post_id' => null,
            'image_path'   => $path,
            'alt_text'     => $file->getClientOriginalName(), // FIX: was getOriginalName
            'sort_order'   => 0,
        ]);

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }
}