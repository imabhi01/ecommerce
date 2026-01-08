<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\Product;

class SlugHelper
{
    public static function unique(string $name): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $count = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
