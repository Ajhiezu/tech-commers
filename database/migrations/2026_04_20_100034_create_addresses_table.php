<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('label')->default('Rumah'); // Rumah, Kantor, etc.
            $table->string('recipient_name');
            $table->string('phone');
            $table->string('province');
            $table->string('province_id')->nullable();
            $table->string('city');
            $table->string('city_id')->nullable();
            $table->string('district')->nullable();
            $table->string('postal_code');
            $table->text('address_detail');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'is_primary']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
