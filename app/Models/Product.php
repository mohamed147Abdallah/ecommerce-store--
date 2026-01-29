<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // هذه الخطوة ضرورية جداً لكي يعمل Product::create
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image'
    ];

    // تعريف العلاقة مع القسم
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}