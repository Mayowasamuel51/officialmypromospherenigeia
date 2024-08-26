<?php

namespace App\Http\Controllers;

use App\Http\Resources\PromoTweet as ResourcesPromoTweet;
use App\Models\PromoTweet as ModelsPromoTweet;
use App\Models\PromoTweetcomment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class PromoTweet extends Controller{

    public function  promotweet(){
        $promotweet =ResourcesPromoTweet::collection(
            DB::table('promo_tweets')
                ->inRandomOrder()
                ->get()
        );
        if ($promotweet) {
            return response()->json([
                'status' => 200,
                'data'  =>  $promotweet
            ]);
          
        }
          return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
    }
    
    public function promotweetsingle($id){
        $fetch_details  = ModelsPromoTweet::find($id);
        // just to add other images to it . that's all 
        // $fetch_details->talkimages->where('promotalkdata_id', $id)->get();
        if($fetch_details) {
            return response()->json([
                'status' => 200,
                'data' => $fetch_details,
                // 'other_data' => $fetch_details_others
            ]);
        }
        // if ($fetch_details->isEmpty()   || $fetch_details_others->isEmpty()  ) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        // }
     
    }

    public function imagestweet(Request $request, $id)
    {
        $request->validate([
            'titleImageurl' => 'required'
        ]);
        if (auth('sanctum')->check()) {
            $item =   ModelsPromoTweet::find($id);
            $filetitleimage = $request->talkimagesurls;
            $loaditem = $item->talkimages()->create([
                'titleImageurl' =>   $filetitleimage
            ]);
            if ($loaditem) { // checking network is okay............................
                return response()->json([
                    'message' => $loaditem
                ]);
            }
        }
        return response()->json([
            'status' => 401,
            'message' => 'You are not unauthenticated Procced to login or register '
        ]);
    }

    public function makepost(Request $request)
    {
        // this , you can add images to this post as a users 
        $request->validate([
            'description' => 'required',
            'title'=>'required'
        ]);
        // if (auth('sanctum')->check()) {
        $items  = new  ModelsPromoTweet;
        $items->user_id = 6;
        // auth()->user()->id;;

        $items->description = $request->description;
        $items->talkid =  rand(1222, 45543);
        $items->user_name= $request->user_name;
        $items->title = $request->title;

        $filetitleimage = $request->file('titleImageurl');
        $folderPath = "public/";
        $fileName =  uniqid() . '.png';
        $file = $folderPath;
        $mainfile =    Storage::put($file, $filetitleimage);
        $items->titleImageurl = $mainfile;

        $items->save();

        return response()->json([
            'status' => 200,
            'item' => $items->id,
            'data' => 'tweet created',
        ]);
        // }
        // return response()->json([
        //     'status' => 500,
        //     'data' => 'User not login '
        // ]);
    }

    public function feedback(Request $request, $itemid){
        $request->validate([
            'name'=>'required',
            'message'=>'required'
        ]);
        $item = ModelsPromoTweet::find($itemid);
        $name = $request->name;
        $message = $request->message;
        $userfeedback= $item->tweetcomment()->create([
            'comment' =>   $message,
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
        $getfeed = PromoTweetcomment::where('promo_tweet_id',$itemid)->get();

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
