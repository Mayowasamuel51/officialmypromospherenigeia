<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all(); // ❌ All user input is passed blindly
        $data['password'] = Hash::make($data['password']); // ✅ at least hash password
        $check = User::create($data); // ❌ Includes any field, like role=admin
        return response()->json([
            'data' => 'info created',
            'status' => 200
        ]);
    }
}


// use Illuminate\Support\Facades\Hash;

// public function store(Request $request)
// {
//     // 1. Only pick expected fields
//     $data = $request->only(['name', 'email', 'password', 'amount']);

//     // 2. Hash the password
//     $data['password'] = Hash::make($data['password']);

//     // 3. Hardcode the role
//     $data['role'] = 'user';

//     // 4. Create the user
//     $check = User::create($data);
//     // OR if you're inside a User-related class, you could use:
//     // $check = $this->create($data);

//     return response()->json([
//         'data' => 'info created',
//         'status' => 200
//     ]);
// }
