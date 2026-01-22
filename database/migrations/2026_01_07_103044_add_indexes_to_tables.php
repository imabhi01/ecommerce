<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Products table indexes
        Schema::table('products', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('created_at');
            // $table->index(['is_active', 'created_at']);
            // $table->index(['category_id', 'is_active']);
            $table->fullText(['name', 'description']);
        });

        // Orders table indexes
        Schema::table('orders', function (Blueprint $table) {
            $table->index('status');
            $table->index('created_at');
            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'created_at']);
        });

        // Cart table indexes
        Schema::table('cart', function (Blueprint $table) {
            $table->index('session_id');
        });

        // Reviews table indexes
        Schema::table('reviews', function (Blueprint $table) {
            $table->index('is_approved');
            $table->index(['product_id', 'is_approved']);
            $table->index('created_at');
        });

        // Categories table indexes
        Schema::table('categories', function (Blueprint $table) {
            $table->index('is_active');
        });

        // Payments table indexes
        Schema::table('payments', function (Blueprint $table) {
            $table->index('payment_method');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // // Use helper function to safely drop indexes if they exist
        // $dropIndexIfExists = function (string $tableName, array $columns, bool $fullText = false) {
        //     $sm = DB::getDoctrineSchemaManager();
        //     $indexes = array_map(fn($i) => $i->getName(), $sm->listTableIndexes($tableName));

        //     foreach ($columns as $column) {
        //         // Doctrine may append "_index" for simple indexes
        //         $indexName = $fullText
        //             ? $tableName . '_' . $column . '_fulltext'
        //             : $tableName . '_' . $column . '_index';

        //         if (in_array($indexName, $indexes)) {
        //             Schema::table($tableName, function (Blueprint $table) use ($column, $fullText) {
        //                 if ($fullText) {
        //                     $table->dropFullText([$column]);
        //                 } else {
        //                     $table->dropIndex([$column]);
        //                 }
        //             });
        //         }
        //     }
        // };

        // // Products
        // Schema::table('products', function (Blueprint $table) {
        //     $table->dropIndex(['is_active']);
        //     $table->dropIndex(['is_featured']);
        //     $table->dropIndex(['created_at']);
        //     // $table->dropIndex(['is_active', 'created_at']);
        //     // $table->dropIndex(['category_id', 'is_active']);
        //     $table->dropFullText(['name', 'description']);
        // });

        // // Orders
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->dropIndex(['status']);
        //     $table->dropIndex(['created_at']);
        //     $table->dropIndex(['user_id', 'status']);
        //     $table->dropIndex(['user_id', 'created_at']);
        // });

        // // Cart
        // Schema::table('cart', function (Blueprint $table) {
        //     $table->dropIndex(['session_id']);
        // });

        // // Reviews
        // Schema::table('reviews', function (Blueprint $table) {
        //     $table->dropIndex(['is_approved']);
        //     $table->dropIndex(['product_id', 'is_approved']);
        //     $table->dropIndex(['created_at']);
        // });

        // Categories
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        // Payments
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['payment_method']);
            $table->dropIndex(['status']);
        });
    }
};
