<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
                        $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->decimal('price', 15, 2);
            $table->decimal('compare_price', 15, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->integer('weight')->default(0); // in grams
            $table->string('sku')->nullable();
            $table->string('status')->default('active'); // Enum: ProductStatus
            $table->boolean('is_featured')->default(false);
            $table->integer('total_sold')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('views_count')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['store_id', 'status', 'created_at']);
            $table->index(['category_id', 'status', 'average_rating']);
            // FULLTEXT added in statement later
        });
        DB::statement('ALTER TABLE products ADD FULLTEXT INDEX fulltext_index (name, description)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
