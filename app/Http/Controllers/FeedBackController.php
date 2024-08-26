<?php

namespace App\Http\Controllers;

use App\Models\FeedBack;
use App\Models\ItemfreeAds;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{
    //

    public function feedback(Request $request, $itemid){
        $request->validate([
            'name'=>'required',
            'message'=>'required'
        ]);
        $item = ItemfreeAds::find($itemid);
        $name = $request->name;
        $message = $request->message;
        $userfeedback= $item->feedsback()->create([
            'message' =>   $message,
            'name'=>$name
            // $request->itemadsimagesurls
        ]);
        if ($userfeedback) { // checking network is okay............................
            return response()->json([
                'status'=>200,
                'data' => $userfeedback
       
            ]);
        }
        return response()->json([
            'status' => 500,
            'message'=>'unable to create a feed back'
        ]);
    }


    public function getfeedback($itemid){
        /// get feedback of a post people made to!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $getfeed = FeedBack::where('itemfree_ads_id',$itemid)->get();

        if($getfeed->isEmpty()){
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $getfeed
        ]);


    }
}
