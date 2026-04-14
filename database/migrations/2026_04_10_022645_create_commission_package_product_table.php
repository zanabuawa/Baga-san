<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commission_package_product', function (Blueprint $table) {
            $table->foreignId('commission_package_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('quantity')->default(1);
            $table->primary(['commission_package_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commission_package_product');
    }
};
