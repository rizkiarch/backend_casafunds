<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Spending;
use Illuminate\Http\Request;

class Spendingcontroller extends Controller
{
    public function index()
    {
        $spendings = Spending::with('category')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Spendings fetched successfully',
            'spendings' => $spendings
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'spending_date' => ['required', 'date'],
        ]);

        $spending = Spending::create($data);
        return response()->json([
            'status' => 201,
            'message' => 'Spending created successfully',
            'spending' => $spending
        ]);
    }

    public function update(Request $request, Spending $spending)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'spending_date' => ['required', 'date'],
        ]);

        $spending->update($data);
        return response()->json([
            'status' => 200,
            'message' => 'Spending updated successfully',
            'spending' => $spending
        ]);
    }

    public function destroy($id)
    {
        try {
            $spending = Spending::find($id);
            $spending->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Spending deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while deleting the spending',
                'error' => $th->getMessage()
            ]);
        }
    }
}
