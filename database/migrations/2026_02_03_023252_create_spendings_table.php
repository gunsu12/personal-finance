<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spendings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->foreignUuid('budget_item_id')->nullable()->constrained('budget_items')->nullOnDelete();
            $table->date('spending_date');
            $table->time('spending_time');
            $table->decimal('amount', 15, 2);
            $table->string('merchant')->nullable();
            $table->enum('transaction_methods', ['qris', 'cash', 'bank', 'others']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spendings');
    }
};
