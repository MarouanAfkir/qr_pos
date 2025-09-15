<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();

            $table->enum('method', ['cash', 'card', 'other'])->default('cash')->index();
            $table->decimal('amount', 10, 2)->default(0);        // amount applied to order
            $table->decimal('amount_given', 10, 2)->default(0);  // for cash
            $table->decimal('change_due', 10, 2)->default(0);

            $table->enum('status', ['captured', 'voided', 'refunded', 'failed'])->default('captured')->index();
            $table->string('reference', 120)->nullable(); // POS ref, terminal txn id, etc.
            $table->json('meta')->nullable();

            $table->timestamp('paid_at')->nullable()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
