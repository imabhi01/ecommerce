<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    protected static function manager()
    {
        return new ImageManager(new Driver());
    }

    public static function optimize($file, $path = 'products', $maxWidth = 1200)
    {
        $manager = self::manager();

        // Create unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $fullPath = $path . '/' . $filename;

        // Read image
        $image = $manager->read($file);

        // Resize if larger than max width
        if ($image->width() > $maxWidth) {
            $image->resize($maxWidth, null);
        }

        // Save optimized image
        Storage::disk('public')->put(
            $fullPath,
            $image->toJpeg(85)
        );

        return $fullPath;
    }

    public static function createThumbnail($imagePath, $width = 300, $height = 300)
    {
        $manager = self::manager();

        $fullImagePath = Storage::disk('public')->path($imagePath);
        $image = $manager->read($fullImagePath);

        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);

        $thumbnailPath = str_replace(
            '.' . $extension,
            '_thumb.' . $extension,
            $imagePath
        );

        $image->cover($width, $height);

        Storage::disk('public')->put(
            $thumbnailPath,
            $image->toJpeg(85)
        );

        return $thumbnailPath;
    }

    public static function delete($path)
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $thumbnailPath = str_replace(
            '.' . $extension,
            '_thumb.' . $extension,
            $path
        );

        if (Storage::disk('public')->exists($thumbnailPath)) {
            Storage::disk('public')->delete($thumbnailPath);
        }
    }
}
