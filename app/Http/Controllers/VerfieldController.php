<?php

namespace App\Http\Controllers;

use App\Models\ItemfreeAds;
use App\Models\ItemsAds;
use App\Models\User;
use Illuminate\Http\Request;

class VerfieldController extends Controller
{
    //   This controller is all about verfield people to be showing on the app 
    // make search for store name 

    public function mainPeople()
    
    {
        // join the user verified along with there uploads goods  using there id
        // $verified = User::where('verified', $searchVerified)->get();
        // join for users table and items table 
        $check_verified =  ItemfreeAds::where('verified', 'verified')->get();

        return  response()->json([
            'status'=>200, 
            'data' => $check_verified
        ]);

    
    }
}
