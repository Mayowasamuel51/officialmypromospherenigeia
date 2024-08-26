<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ItemfreeAds;
use App\Models\ItemfreeVideosAds;
use Illuminate\Http\Request;

class TrendingAds extends Controller
{
    // Goal   building a recommendation API  for First time Users and other user 

    public function index(Request $request)
    {
        // just guessing  combine two tables together  then use eager loading  showing just (Main images and videos along  profile icon ) 
        // dont forget to paginate
        $itemfree_ads = ItemfreeAds::all();
        $itemfree_vidoes_ads = ItemfreeVideosAds::all();
        return response()->json([
            'status' => 200, 
            'message' => 'showing paid plans',
            'data1' => $itemfree_ads,
            'data2' => $itemfree_vidoes_ads
        ]);

    }
}
