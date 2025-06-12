<?php

namespace App\Http\Controllers;

use App\Models\Learning as ModelsLearning;
use Illuminate\Http\Request;

class Learning extends Controller
{
    //

    public function  post(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'coursetype','required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $student_info = new ModelsLearning;
        $student_info->id_number= rand(1222, 45543);
        $student_info->name = $request->name;
        $student_info->coursetype = $request->coursetype;
        $student_info->email = $request->email;
        $student_info->phone = $request->phone;


        $student_info->save();

        return response()->json([
            'status' => 200,
            'item' => $student_info,
            'data' => 'info created'
        ]);
    }
}
