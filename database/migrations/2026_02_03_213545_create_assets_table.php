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
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['gold', 'fund', 'stock', 'bonds', 'deposito', 'saving', 'cash']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('qty', 20, 10);
            $table->string('unit');
            $table->decimal('price', 15, 2);
            $table->decimal('sub_total', 15, 2);
            $table->decimal('expected_return', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
