<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();

            // Link to your external/catalog item if available
            $table->unsignedBigInteger('catalog_item_id')->nullable()->index();
            $table->unsignedBigInteger('catalog_category_id')->nullable()->index();

            // Immutable snapshot for receipts/history
            $table->string('item_name', 180);
            $table->string('category_name', 120)->nullable();
            $table->string('image_url', 1024)->nullable();

            // Pricing
            $table->decimal('base_unit_price', 10, 2)->default(0); // before options
            $table->decimal('unit_price', 10, 2)->default(0);      // after options
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('line_total', 10, 2)->default(0);

            $table->text('notes')->nullable();
            $table->json('data')->nullable(); // any extra snapshot

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
