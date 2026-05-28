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
        Schema::create('commission_rules', function (Blueprint $table) {
                        $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete(); // null = global
            $table->decimal('percentage', 5, 2)->default(0);
            $table->decimal('fixed_amount', 15, 2)->default(0);
            $table->timestamp('effective_from');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_rules');
    }
};
