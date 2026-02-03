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
        Schema::create('budget_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('budget_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->enum('type', ['konsumsi', 'sewa', 'pakaian', 'utilitas', 'hiburan', 'lainnya']);
            $table->decimal('amount', 15, 2);
            $table->integer('qty')->default(1);
            $table->decimal('sub_total', 15, 2);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_items');
    }
};
