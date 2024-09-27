<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::chunk(50, function ($usersChunk) use (&$users) {
            $users = $usersChunk;
        });

        return response()->json([
            'users' => $users
        ]);
    }
}
