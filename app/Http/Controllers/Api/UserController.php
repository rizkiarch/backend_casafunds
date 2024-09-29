<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('houses', 'houses.payments')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Users fetched successfully',
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'full_name' => ['required', 'string'],
                'phone_number' => ['nullable', 'string'],
                'photo_ktp' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif',  'max:5120'],

                'username' => ['nullable', 'string', 'unique:users'],
                'email' => ['nullable', 'email', 'unique:users'],
                'password' => ['nullable', 'string', 'min:8'],

                'role' => ['nullable', 'string'],
                'status' => ['nullable', 'string'],
                'is_married' => ['nullable', 'boolean'],
            ]);

            $data['password'] = bcrypt($data['password']);

            $username = $data['username'];
            if ($request->hasFile('photo_ktp')) {
                $file = $request->file('photo_ktp');
                $filename = $username . '-' .  date('YmdHi') . '.' . $file->getClientOriginalExtension();
                // $path = $file->storeAs('photo_ktp', $filename);
                $path = $file->move(public_path('storage'), $filename);
                $data['photo_ktp'] = 'storage/' . $filename;
            }

            $user = User::create($data);

            return response()->json([
                'message' => 'User created successfully',
                'user' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred while creating the user',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    // public function update(Request $request, User $user)
    // {
    //     try {
    //         $data = $request->validate([
    //             'full_name' => ['required', 'string'],
    //             'phone_number' => ['nullable', 'string'],
    //             'photo_ktp' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif', 'max:5120'],

    //             'username' => ['required', 'string', 'unique:users,username,' . $user->id],
    //             'email' => ['required', 'email', 'unique:users,email,' . $user->id],
    //             'password' => ['nullable', 'string', 'min:8'],

    //             'role' => ['nullable', 'string'],
    //             'status' => ['nullable', 'string'],
    //             'is_married' => ['nullable', 'boolean'],
    //         ]);

    //         if (isset($data['password'])) {
    //             $data['password'] = bcrypt($data['password']);
    //         } else {
    //             unset($data['password']);
    //         }

    //         if ($request->hasFile('photo_ktp')) {
    //             $file = $request->file('photo_ktp');
    //             $filename = $user->username . '-' . date('YmdHi') . '.' . $file->getClientOriginalExtension();
    //             $file->move(public_path('photo_ktp'), $filename);
    //             $data['photo_ktp'] = 'photo_ktp/' . $filename;

    //             if ($user->photo_ktp && file_exists(public_path($user->photo_ktp))) {
    //                 unlink(public_path($user->photo_ktp));
    //             }
    //         } else {
    //             $data['photo_ktp'] = $user->photo_ktp;
    //         }

    //         $user->update($data);

    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'User updated successfully',
    //             'user' => $user
    //         ]);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'message' => 'An error occurred while updating the user',
    //             'error' => $th->getMessage()
    //         ], 500);
    //     }
    // }

    // public function update(Request $request, User $user)
    // {
    //     try {
    //         $data = $request->validate([
    //             'full_name' => ['required', 'string'],
    //             'phone_number' => ['nullable', 'string'],
    //             'photo_ktp' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif', 'max:5120'],

    //             'username' => ['nullable', 'string', 'unique:users,username,' . $user->id],
    //             'email' => ['nullable', 'email', 'unique:users,email,' . $user->id],
    //             'password' => ['nullable', 'string', 'min:8'],

    //             'role' => ['nullable', 'string'],
    //             'status' => ['nullable', 'string'],
    //             'is_married' => ['nullable', 'boolean'],
    //         ]);
    //         if (!empty($data['password'])) {
    //             $data['password'] = bcrypt($data['password']);
    //         } else {
    //             unset($data['password']);
    //         }

    //         if ($request->hasFile('photo_ktp')) {
    //             $file = $request->file('photo_ktp');
    //             $filename = $user->username . '-' . date('YmdHi') . '.' . $file->getClientOriginalExtension();
    //             $file->move(public_path('photo_ktp'), $filename);
    //             $data['photo_ktp'] = 'photo_ktp/' . $filename;

    //             if ($user->photo_ktp && file_exists(public_path($user->photo_ktp))) {
    //                 unlink(public_path($user->photo_ktp));
    //             }
    //         }
    //         $user->update($data);

    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'User updated successfully',
    //             'user' => $user
    //         ]);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'message' => 'An error occurred while updating the user',
    //             'error' => $th->getMessage()
    //         ], 500);
    //     }
    // }

    public function update(Request $request, User $user)
    {
        try {
            // Validasi data dari request
            $data = $request->validate([
                'full_name' => ['required', 'string'],
                'phone_number' => ['nullable', 'string'],
                'photo_ktp' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif', 'max:5120'],

                'username' => ['nullable', 'string', 'unique:users,username,' . $user->id],
                'email' => ['nullable', 'email', 'unique:users,email,' . $user->id],
                'password' => ['nullable', 'string', 'min:8'],

                'role' => ['nullable', 'string'],
                'status' => ['nullable', 'string'],
                'is_married' => ['nullable', 'boolean'],
            ]);

            // Hash password jika ada
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']); // Jika tidak ada password, hapus dari array data
            }

            // Proses file upload photo_ktp jika ada
            if ($request->hasFile('photo_ktp')) {
                $file = $request->file('photo_ktp');
                $filename = $user->username . '-' . date('YmdHi') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('photo_ktp'), $filename);
                $data['photo_ktp'] = 'photo_ktp/' . $filename;

                // Hapus file lama jika ada
                if ($user->photo_ktp && file_exists(public_path($user->photo_ktp))) {
                    unlink(public_path($user->photo_ktp));
                }
            }

            // Update user dengan data yang telah di-validate
            $user->update($data);

            // Refresh user dari database untuk memastikan data terbaru dikembalikan
            $user->refresh();

            if ($user == null) {
                return response()->json([
                    'status' => 404,
                    'message' => 'User not found',
                ]);
            }
            // Return response sukses dengan data user terbaru
            return response()->json([
                'status' => 200,
                'message' => 'User updated successfully',
                'user' => $user // User yang sudah terupdate
            ]);
        } catch (\Throwable $th) {
            // Return response error jika terjadi exception
            return response()->json([
                'message' => 'An error occurred while updating the user',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
