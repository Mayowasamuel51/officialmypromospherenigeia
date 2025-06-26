<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminContoller extends Controller
{
    //



      public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Hardcoded admin credentials
        if ($request->email === 'admin' && $request->password === '1234') {
            // Store login in session (optional)
            // session(['is_admin_logged_in' => true]);
              return response()->json([
                'status' => 200,
                'message' => 'YOU ARE IN NOW '
            ], 200);
        }

        return back()->withErrors(['Invalid credentials'])->withInput();
    }


}
