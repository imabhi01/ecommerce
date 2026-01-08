<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{

    // INDEX PAGE WITHOUT CACHING

    // public function index()
    // {
    //     // Statistics
    //     $totalOrders = Order::count();
    //     $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
    //     $totalProducts = Product::count();
    //     $totalCustomers = User::where('is_admin', false)->count();

    //     // Recent orders
    //     $recentOrders = Order::with('user')
    //         ->orderBy('created_at', 'desc')
    //         ->limit(10)
    //         ->get();

    //     // Monthly revenue (last 12 months)
    //     $monthlyRevenue = Order::where('status', '!=', 'cancelled')
    //         ->where('created_at', '>=', now()->subMonths(12))
    //         ->select(
    //             DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
    //             DB::raw('SUM(total) as revenue')
    //         )
    //         ->groupBy('month')
    //         ->orderBy('month')
    //         ->get();

    //     // Top selling products
    //     $topProducts = Product::withCount(['orderItems' => function($query) {
    //         $query->select(DB::raw('SUM(quantity)'));
    //     }])
    //     ->orderBy('order_items_count', 'desc')
    //     ->limit(5)
    //     ->get();

    //     // Order status distribution
    //     $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
    //         ->groupBy('status')
    //         ->get()
    //         ->pluck('count', 'status');

    //     return view('admin.dashboard', compact(
    //         'totalOrders',
    //         'totalRevenue',
    //         'totalProducts',
    //         'totalCustomers',
    //         'recentOrders',
    //         'monthlyRevenue',
    //         'topProducts',
    //         'ordersByStatus'
    //     ));
    // }


    //WITH CACHING
    public function index(){
        // Cache statistics for 5 minutes
        $statistics = Cache::remember('admin_dashboard_stats', 300, function () {
            return [
                'totalOrders' => Order::count(),
                'totalRevenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
                'totalProducts' => Product::count(),
                'totalCustomers' => User::where('is_admin', false)->count(),
            ];
        });

        // Recent orders with eager loading
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // Monthly revenue (last 12 months) - cache for 1 hour
        $monthlyRevenue = Cache::remember('monthly_revenue', 3600, function () {
            return Order::where('status', '!=', 'cancelled')
                ->where('created_at', '>=', now()->subMonths(12))
                ->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                    DB::raw('SUM(total) as revenue')
                )
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        });

        // Top selling products with order count
        $topProducts = Product::withCount(['orderItems' => function($query) {
            $query->select(DB::raw('SUM(quantity)'));
        }])
        ->orderBy('order_items_count', 'desc')
        ->limit(5)
        ->get();

        // Order status distribution
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        return view('admin.dashboard', compact(
            'recentOrders',
            'monthlyRevenue',
            'topProducts',
            'ordersByStatus'
        ) + $statistics);
    }
}
