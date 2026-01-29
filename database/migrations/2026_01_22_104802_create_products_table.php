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
            // الربط مع جدول الأقسام (تأكد أن جدول categories تم إنشاؤه قبل هذا الجدول)
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2); // 10 أرقام إجمالاً، منهم 2 عشري
            $table->integer('stock')->default(0);
            $table->string('image')->nullable(); // يسمح بأن يكون الحقل فارغاً في قاعدة البيانات
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