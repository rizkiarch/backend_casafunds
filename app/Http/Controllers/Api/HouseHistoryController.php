<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\House_history;
use Illuminate\Http\Request;

class HouseHistoryController extends Controller
{
    public function index()
    {
        $houseHistories = House_history::with('house', 'user')->get();
        return response()->json([
            'status' => 200,
            'message' => 'House histories fetched successfully',
            'houseHistories' => $houseHistories
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'house_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
        ]);

        $existingData = House_history::where('house_id', $data['house_id'])
            ->whereNull('end_date')->first();

        if ($existingData) {
            return response()->json([
                'status' => 400,
                'message' => 'House is already occupied'
            ]);
        }

        $houseHistory = HouseHistory::create($data);
        return response()->json([
            'status' => 201,
            'message' => 'House history created successfully',
            'houseHistory' => $houseHistory
        ]);
    }

    public function update(Request $request, House_history $houseHistory)
    {
        $data = $request->validate([
            'house_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
        ]);

        $houseHistory->update($data);
        $this->updateHouse($data);
        return response()->json([
            'status' => 200,
            'message' => 'House history updated successfully',
            'houseHistory' => $houseHistory
        ]);
    }

    public function updateHouse($data)
    {
        $house = House::find($data['house_id']);
        $house->update([
            'user_id' => $data['user_id'],
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'House updated successfully',
            'house' => $house
        ]);
    }

    public function destroy($id)
    {
        try {
            $houseHistory = HouseHistory::find($id);
            $houseHistory->delete();
            return response()->json([
                'status' => 200,
                'message' => 'House history deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while deleting the house history',
                'error' => $th->getMessage()
            ]);
        }
    }
}
