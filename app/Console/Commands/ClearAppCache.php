<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearAppCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:clear-app-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    
    protected $signature = 'app:clear-cache {type?}';
    protected $description = 'Clear application cache by type';

    public function handle()
    {
        $type = $this->argument('type');

        switch ($type) {
            case 'products':
                $this->clearProductCache();
                break;
            case 'categories':
                $this->clearCategoryCache();
                break;
            case 'dashboard':
                $this->clearDashboardCache();
                break;
            case 'all':
            default:
                Cache::flush();
                $this->info('All cache cleared!');
                break;
        }
    }

    private function clearProductCache()
    {
        $products = \App\Models\Product::all();
        foreach ($products as $product) {
            Cache::forget("product_{$product->slug}");
        }
        $this->info('Product cache cleared!');
    }

    private function clearCategoryCache()
    {
        Cache::forget('active_categories');
        $categories = \App\Models\Category::all();
        foreach ($categories as $category) {
            Cache::forget("category_{$category->slug}");
        }
        $this->info('Category cache cleared!');
    }

    private function clearDashboardCache()
    {
        Cache::forget('admin_dashboard_stats');
        Cache::forget('monthly_revenue');
        $this->info('Dashboard cache cleared!');
    }
}
