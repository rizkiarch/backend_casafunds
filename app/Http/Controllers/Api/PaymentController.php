<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('house', 'house.user', 'user', 'user.houses')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Payments fetched successfully',
            'payments' => $payments
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'user_id' => ['required', 'exists:users,id'],
                'house_id' => ['required', 'exists:houses,id'],
                'payment_date' => ['required', 'date'],
                'iuran_kebersihan' => ['required', 'numeric', 'min:0'],
                'iuran_satpam' => ['required', 'numeric', 'min:0'],
                'is_paid' => ['nullable', 'boolean'],
                'paid_at' => ['nullable', 'date'],
                'description' => ['nullable', 'string']
            ]);

            if ($data['iuran_satpam'] < 100000 || $data['iuran_kebersihan'] < 15000) {
                $data['is_paid'] = false;
            } else {
                $data['is_paid'] = true;
                $data['paid_at'] = now();
            }

            $house = House::find($data['house_id']);
            if (!$house || $house->user_id != $data['user_id']) {
                return response()->json([
                    'status' => 400,
                    'message' => "Penghuni Tidak Sesuai dengan Rumah, cobalah gunakan rumah yang kosong"
                ], 400);
            }

            $payment = Payment::create($data);
            return response()->json([
                'status' => 201,
                'message' => 'Payment created successfully',
                'payment' => $payment
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while creating the payment',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'house_id' => ['required', 'exists:houses,id'],
            'payment_date' => ['required', 'date'],
            'iuran_kebersihan' => ['required', 'numeric', 'min:0'],
            'iuran_satpam' => ['required', 'numeric', 'min:0'],
            'is_paid' => ['nullable', 'boolean'],
            'paid_at' => ['nullable', 'date'],
            'description' => ['nullable', 'string']
        ]);

        if ($data['iuran_satpam'] < 100000 || $data['iuran_kebersihan'] < 15000) {
            $data['is_paid'] = false;
        } else {
            $data['is_paid'] = true;
            $data['paid_at'] = now();
        }

        $house = House::find($data['house_id']);
        if (!$house || $house->user_id != $data['user_id']) {
            return response()->json([
                'status' => 400,
                'message' => "House or User not valid"
            ], 400);
        }

        $payment->update($data);
        return response()->json([
            'status' => 200,
            'message' => 'Payment updated successfully',
            'payment' => $payment
        ]);
    }

    public function destroy($id)
    {
        // try {
        //     $payment = Payment::find($id);
        //     $payment->delete();
        //     return response()->json([
        //         'status' => 200,
        //         'message' => 'Payment deleted successfully'
        //     ]);
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'status' => 500,
        //         'message' => 'An error occurred while deleting the payment',
        //         'error' => $th->getMessage()
        //     ]);
        // }
    }
}
