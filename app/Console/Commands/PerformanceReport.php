<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PerformanceReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:performance-report';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    protected $signature = 'app:performance-report';
    protected $description = 'Generate performance report';

    public function handle()
    {
        $this->info('Performance Report');
        $this->info('==================');
        $this->newLine();

        // Database Stats
        $this->info('Database Statistics:');
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Products', \App\Models\Product::count()],
                ['Active Products', \App\Models\Product::where('is_active', true)->count()],
                ['Total Orders', \App\Models\Order::count()],
                ['Total Users', \App\Models\User::count()],
                ['Total Reviews', \App\Models\Review::count()],
            ]
        );
        $this->newLine();

        // Cache Stats
        $this->info('Cache Information:');
        $this->line('Cache Driver: ' . config('cache.default'));
        $this->newLine();

        // Slow Queries (if query log is enabled)
        $this->info('Recent Query Performance:');
        DB::enableQueryLog();
        
        // Run a test query
        \App\Models\Product::with(['category', 'primaryImage'])->limit(10)->get();
        
        $queries = DB::getQueryLog();
        $this->line('Sample queries executed: ' . count($queries));
        $this->newLine();

        // Image Stats
        $this->info('Image Storage:');
        $productImages = \App\Models\ProductImage::count();
        $this->line('Total Product Images: ' . $productImages);
        $this->newLine();

        // Recommendations
        $this->info('Recommendations:');
        if (config('cache.default') === 'file') {
            $this->warn('- Consider using Redis for caching in production');
        }
        if (!config('app.debug')) {
            $this->info('✓ Debug mode is disabled (good for production)');
        } else {
            $this->warn('- Debug mode is enabled (disable in production)');
        }
        
        $this->newLine();
        $this->info('Report complete!');
    }
}
