<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_item_options', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('order_item_id')->constrained('order_items')->cascadeOnDelete();

            // Link to catalog if available (optional)
            $table->unsignedBigInteger('catalog_variation_id')->nullable()->index();
            $table->unsignedBigInteger('catalog_option_id')->nullable()->index();

            // Immutable snapshot
            $table->string('variation_name', 160);
            $table->string('option_name', 160);

            // Price adjustment (can be negative/zero/positive)
            $table->decimal('price_adjustment', 10, 2)->default(0);

            $table->unsignedSmallInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['order_item_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_item_options');
    }
};
