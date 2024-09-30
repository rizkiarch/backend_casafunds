<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\House;
use App\Models\House_history;

class HouseController extends Controller
{
    public function index()
    {
        // $houses = [];
        // House::with('user')->chunk(100, function ($chunk) use (&$houses) {
        //     foreach ($chunk as $house) {
        //         $houses[] = $house;
        //     }
        // });

        $houses = House::with('user')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Houses fetched successfully',
            'houses' => $houses
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'address' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'user_id' => ['nullable', 'integer'],

            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
        ]);

        if (empty($data['user_id'])) {
            $data['user_id'] = null;
            $house = House::create([
                'address' => $data['address'],
                'status' => $data['status'],
                'user_id' => $data['user_id'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
            ]);
        } else {
            $house = House::create([
                'address' => $data['address'],
                'status' => $data['status'],
                'user_id' => $data['user_id'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
            ]);
            $this->storeHistories($data, $house);
        }

        return response()->json([
            'status' => 201,
            'message' => 'House created successfully',
            'house' => $house
        ]);
    }

    public function storeHistories($data, $house)
    {
        $data = [
            'house_id' => $house->id,
            'user_id' => $house->user_id,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
        ];

        $existingData = House_history::where('house_id', $data['house_id'])
            ->whereNull('end_date')->first();

        if ($existingData) {
            return response()->json([
                'status' => 400,
                'message' => 'House is already occupied'
            ]);
        }

        $houseHistory = House_history::create($data);
        return response()->json([
            'status' => 201,
            'message' => 'House history created successfully',
            'houseHistory' => $houseHistory
        ]);
    }

    public function update(Request $request, House $house)
    {
        $data = $request->validate([
            'address' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'user_id' => ['nullable', 'integer'],

            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
        ]);

        $existingData = House_history::where('house_id', $house->id)
            ->whereNull('end_date')
            ->orderBy('id', 'desc')
            ->first();

        if ($existingData) {
            $data['start_date'] = $data['start_date'] ?: $existingData->start_date;
            $data['end_date'] = $data['end_date'] ?: $existingData->end_date;
        }

        $this->updateHouseData($house, $data);

        if (!empty($data['user_id'])) {
            $this->updateHistories($data, $house);
        }

        return response()->json([
            'status' => 200,
            'message' => 'House updated successfully',
            'house' => $house
        ]);
    }

    private function updateHouseData(House $house, array $data)
    {
        // Perbarui data rumah
        $house->update([
            'address' => $data['address'],
            'status' => $data['status'],
            'user_id' => $data['user_id'] ?? null, // Menjaga nilai null jika tidak ada user_id
            // $data['start_date'] = $data['start_date'],
            // $data['end_date'] = $data['end_date'],
        ]);
    }

    private function updateHistories($data, $house)
    {
        $data = [
            'house_id' => $house->id,
            'user_id' => $house->user_id,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
        ];

        $existingData = House_history::where('house_id', $data['house_id'])
            ->whereNull('end_date')
            ->orderBy('id', 'desc')
            ->first();

        if ($existingData && $existingData->user_id == $data['user_id']) {
            $existingData->update([
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
            ]);
            $houseHistory = $existingData;
        } else {
            if ($existingData) {
                $existingData->update(['end_date' => $data['start_date']]);
            }
            $houseHistory = House_history::create($data);
        }

        return response()->json([
            'status' => 201,
            'message' => 'House history updated successfully',
            'houseHistory' => $houseHistory
        ]);
    }

    public function destroy($id)
    {
        $existingHistory = House_history::where('house_id', $id)
            ->first();
        if ($existingHistory) {
            return response()->json([
                'status' => 400,
                'message' => 'Cannot delete house because it has associated histories'
            ]);
        }

        $house = House::findOrFail($id);
        $house->delete();

        return response()->json([
            'status' => 200,
            'message' => 'House deleted successfully'
        ]);
    }
}
