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
       Schema::create('products', function (Blueprint $table) {
    $table->id();

    $table->string('name');
    $table->string('slug')->unique();

    $table->foreignId('category_id')->constrained()->cascadeOnDelete();

    // 🔥 Egg / Hen
    $table->enum('type', ['egg', 'hen']);

    $table->decimal('price', 10, 2);
    $table->decimal('bulk_price', 10, 2)->nullable();

    $table->integer('min_order_qty')->default(1); // 🔥 important
    $table->integer('stock')->default(0);

    $table->text('description')->nullable();

    $table->boolean('status')->default(1);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
