<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('status');
            $table->string('phone')->nullable()->after('customer_name');
            $table->text('address')->nullable()->after('phone');
            $table->string('city')->nullable()->after('address');
            $table->string('payment_method')->default('cash')->after('city');
            $table->text('notes')->nullable()->after('payment_method');
            $table->decimal('unit_price', 10, 2)->nullable()->after('notes');
            $table->decimal('total_price', 10, 2)->nullable()->after('unit_price');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'phone',
                'address',
                'city',
                'payment_method',
                'notes',
                'unit_price',
                'total_price',
            ]);
        });
    }
};
