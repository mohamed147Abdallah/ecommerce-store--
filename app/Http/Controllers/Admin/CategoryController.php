<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. التحقق من البيانات
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // 2. إنشاء القسم (مع توليد Slug تلقائياً)
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // تحويل الاسم لرابط (e.g. Smart Phones -> smart-phones)
        ]);

        // 3. التوجيه
        // نعيده لصفحة إضافة المنتج ليكمل عمله
        return redirect()->route('products.create')->with('success', 'Category created successfully! You can now select it.');
    }
}