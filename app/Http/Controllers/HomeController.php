<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * عرض الصفحة الرئيسية
     */
    public function index()
    {
        // جلب الأقسام
        $categories = Category::all();
        // جلب أحدث 8 منتجات للصفحة الرئيسية
        $latestProducts = Product::with('category')->latest()->take(8)->get();

        return view('welcome', compact('categories', 'latestProducts'));
    }

    /**
     * البحث عن المنتجات
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $categories = Category::all();
        
        // البحث في اسم المنتج أو الوصف
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->with('category')
            ->paginate(12);

        // توجيه النتائج لصفحة عرض المنتجات
        return view('products.index', compact('categories', 'products'));
    }

    /**
     * فلترة المنتجات حسب القسم
     */
    public function category($id)
    {
        $categories = Category::all();
        $category = Category::findOrFail($id);
        
        // هذا المتغير يستخدم لتمييز القسم الحالي في الواجهة
        $currentCategory = $category; 

        // جلب منتجات القسم المحدد
        $products = Product::where('category_id', $id)
            ->with('category')
            ->paginate(12);

        return view('products.index', compact('categories', 'products', 'currentCategory'));
    }
}