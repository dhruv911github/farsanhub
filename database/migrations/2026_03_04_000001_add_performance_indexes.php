<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // customers: index user_id for fast per-user queries
        Schema::table('customers', function (Blueprint $table) {
            $table->index('user_id', 'idx_customers_user_id');
        });

        // products: index user_id
        Schema::table('products', function (Blueprint $table) {
            $table->index('user_id', 'idx_products_user_id');
        });

        // orders: index user_id, customer_id, product_id, and composite for date range reports
        Schema::table('orders', function (Blueprint $table) {
            $table->index('user_id', 'idx_orders_user_id');
            $table->index('customer_id', 'idx_orders_customer_id');
            $table->index('product_id', 'idx_orders_product_id');
            $table->index(['user_id', 'created_at'], 'idx_orders_user_created');
        });

        // expenses: index user_id and composite for date range queries
        Schema::table('expenses', function (Blueprint $table) {
            $table->index('user_id', 'idx_expenses_user_id');
            $table->index(['user_id', 'date'], 'idx_expenses_user_date');
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex('idx_customers_user_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_user_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_orders_user_id');
            $table->dropIndex('idx_orders_customer_id');
            $table->dropIndex('idx_orders_product_id');
            $table->dropIndex('idx_orders_user_created');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropIndex('idx_expenses_user_id');
            $table->dropIndex('idx_expenses_user_date');
        });
    }
};
