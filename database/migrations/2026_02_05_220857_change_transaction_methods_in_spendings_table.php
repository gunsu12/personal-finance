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
        Schema::table('spendings', function (Blueprint $table) {
            $table->string('transaction_methods')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spendings', function (Blueprint $table) {
            // Reverting to enum is tricky without raw SQL, but best effort:
            // $table->enum('transaction_methods', ['qris', 'cash', 'bank', 'others'])->change();
        });
    }
};
