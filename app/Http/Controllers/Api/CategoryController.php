<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $data = Category::create($data);
        return response()->json([
            'status' => 201,
            'message' => 'Category created successfully',
            'category' => $data
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $category->update($data);
        return response()->json([
            'status' => 200,
            'message' => 'Category updated successfully',
            'category' => $category
        ]);
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            $category->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Category deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while deleting the category',
                'error' => $th->getMessage()
            ]);
        }
    }
}
