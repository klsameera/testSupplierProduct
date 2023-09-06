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
            $table->string('code');
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('quantity', 10, 2)->default(0.00);
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->string('status')->enum(['enable', 'disable'])->default('enable');
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
