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
        Schema::table('users', function (Blueprint $table) {
            // إضافة عمود is_admin من نوع boolean (صحيح/خطأ)
            // default(false) تعني أن أي مستخدم جديد سيكون مستخدم عادي وليس أدمن بشكل افتراضي
            $table->boolean('is_admin')->default(false)->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // حذف العمود في حالة التراجع عن الـ migration
            $table->dropColumn('is_admin');
        });
    }
};