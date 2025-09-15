<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Context
            $table->foreignId('restaurant_id')->nullable()
                ->constrained('restaurants')->nullOnDelete(); // adjust table name if needed
            $table->string('order_code', 40)->unique(); // e.g. "ORD-20250826-0001"

            // Dine-in / Takeaway / Delivery
            $table->enum('order_type', ['dinein', 'takeaway', 'delivery'])->default('dinein')->index();
            $table->unsignedSmallInteger('table_number')->nullable()->index(); // for dine-in

            // Status lifecycle
            $table->enum('status', ['draft', 'held', 'open', 'paid', 'voided', 'refunded'])
                  ->default('open')->index();

            // Money (no service/tax as requested)
            $table->char('currency', 8)->default('DH'); // " DH"
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->enum('discount_type', ['amount', 'percent'])->default('amount');
            $table->decimal('discount_value', 10, 2)->default(0); // raw input (amount or %)
            $table->decimal('discount_amount', 10, 2)->default(0); // computed money
            $table->decimal('total', 10, 2)->default(0);

            // Optional customer / notes
            $table->string('customer_name', 120)->nullable();
            $table->string('customer_phone', 40)->nullable();
            $table->text('notes')->nullable();

            // Timestamps
            $table->timestamp('placed_at')->nullable()->index();
            $table->timestamp('closed_at')->nullable()->index();

            // Auditing / extensibility
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('closed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->json('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
