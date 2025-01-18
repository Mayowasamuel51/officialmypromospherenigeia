<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ItemfreeAds;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// this api is part of the home page .....
class HomeTalkTweetUser extends Controller
{
    //
    public function topseller()
    {
        //    showing sellers images and seller name  able to click on them 
        $seller_data =  DB::table('users')->select('profileImage', 'name')->latest()->get();
        //  DB::table('SELECT profileImage , name from users')->get();

        // $second_data  = User::where()

        return response()->json([
            'status' => 200,
            'data' => $seller_data
        ]);
    }

    // this function get everything about our top-sellers eg , koko sytle , and others 
    public function personalSeller($seller_name)
    {
        //show the name first 
        // then display all or some product 
        $personal_top_seller = ItemfreeAds::where('user_name', $seller_name)->limit(8)->get();
        return response()->json([
            'status' => 200,
            'data' => $personal_top_seller
        ]);
    }
}
