<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // عرض كل الكاتيغوريز
    public function index()
    {
        $categories = Category::all();
        return view('categories', compact('categories'));
    }

    // حفظ كاتيغوري جديدة
public function store(Request $request)
{
    $request->validate([
        'name' => 'required'
    ]);

    Category::create(['name' => $request->name]);

    return response()->json([
        'icon' => 'success',
        'title' => 'Category Added!'
    ]);
}

    // حذف كاتيغوري
public function destroy(Category $category)
{
    $category->delete();
    return response()->json(['success' => true]);
}
}
