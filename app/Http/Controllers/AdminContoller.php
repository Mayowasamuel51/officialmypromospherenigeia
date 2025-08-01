<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminContoller extends Controller
{
    //



    //   public function login(Request $request)
    // {


    //     // Hardcoded admin credentials
    //     if ($request->email === 'admin' && $request->password === '1234') {
    //         // Store login in session (optional)
    //         // session(['is_admin_logged_in' => true]);
    //           return response()->json([
    //             'status' => 200,
    //             'message' => 'YOU ARE IN NOW '
    //         ], 200);
    //     }

    //     return back()->withErrors(['Invalid credentials'])->withInput();
    // }


    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = DB::select("SELECT * FROM admins WHERE email = '$email' AND password = '$password'");

        if ($user) {
            return response()->json([
                'status' => 200,
                'message' => 'YOU ARE IN NOW '
            ], 200);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Invalid credentials'
        ]);
    }
}
