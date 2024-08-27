<?php

namespace App\Http\Controllers;

use App\Http\Resources\PromoTalk as ResourcesPromoTalk;
use App\Models\Promotalkcomment;
use App\Models\Promotalkdata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PromoTalk extends Controller
{

    public function selectingTalk ($categories)
    {
        /// this will be a select box to switch in between tweets 
        $categories = [
            'sex',
            'products',
            'online market place',
            "politics",
            "economy",
            "entertainment",
            "education",
            "sports",
            "health",
            "religion",
            "technology",
            "culture",
            "relationships",
            "career",
            "fashion",
            "business",
            "social media",
            "music",
            "movies",
            "food",
            "travel",
            "real estate",
            "entrepreneurship"
        ];
        $promotalk =  ResourcesPromoTalk::collection(
            DB::table('promo_tweets')
                ->where('categories', $categories)
                ->get()
        );

        if ($promotalk) {
            return response()->json([
                'status' => 200,
                'data'  =>  $promotalk
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'No orders found matching the query.'
        ], 404);
    }

    public function  promotalksidebar()
    {
        $promotalk = ResourcesPromoTalk::collection(

            DB::table('promotalkdatas')
                ->orWhere('description', 'like', '%product%')
                ->orWhere('description', 'like', '%land%')->orWhere('description', 'like', '%youtude%')->orWhere('description', 'like', '%developer%')->orWhere('description', 'like', '%knack%')->orWhere('description', 'like', '%knacking%')
                ->orWhere('description', 'like', '%facebook%')
                ->orWhere('description', 'like', '%lover%')
                ->where('description', 'like', '%sex%')
                ->orWhere('description', 'like', '%help%')
                ->orWhere('description', 'like', '%lover%')
                ->orWhere('description', 'like', '%lady%')
                ->orWhere('description', 'like', '%fuck%')
                ->inRandomOrder()
                ->get()
        );
        if ($promotalk) {
            return response()->json([
                'status' => 200,
                'data'  =>  $promotalk
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'No orders found matching the query.'
        ], 404);
    }
    public function  promotalk()
    {
        $promotalk = ResourcesPromoTalk::collection(

            DB::table('promotalkdatas')
                // ->orWhere('description', 'like', '%product%')
                // ->orWhere('description', 'like', '%land%')->orWhere('description', 'like', '%youtude%')->orWhere('description', 'like', '%developer%')->orWhere('description', 'like', '%knack%')->orWhere('description', 'like', '%knacking%')
                // ->orWhere('description', 'like', '%facebook%')
                // ->orWhere('description', 'like', '%lover%')
                // ->where('description', 'like', '%sex%')
                // ->orWhere('description', 'like', '%help%')
                // ->orWhere('description', 'like', '%lover%')
                ->orWhere('description', 'like', '%lady%')
                // ->orWhere('description', 'like', '%fuck%')
                ->inRandomOrder()
                ->get()
        );
        if ($promotalk) {
            return response()->json([
                'status' => 200,
                'data'  =>  $promotalk
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'No orders found matching the query.'
        ], 404);
    }
    public function promotalksingle($id)
    {
        // display the commnet made one this post 


        $fetch_details  = Promotalkdata::find($id);
        // / $fetch_details->talkimages->where('promotalkdata_id', $id)->get();
        $fetch_comment = Promotalkdata::find($id)->comment()->where('promotalkdata_id', $id)->inRandomOrder()->get();;
        // just to add other images to it . that's all 

        if ($fetch_details) {
            return response()->json([
                'status' => 200,
                'data' => $fetch_details,
                'commnet' => $fetch_comment
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

    public function promotalksidebarsingle($id)
    {
        $fetch_details  = Promotalkdata::find($id);
        // / $fetch_details->talkimages->where('promotalkdata_id', $id)->get();
        $fetch_comment = Promotalkdata::find($id)->comment()->where('promotalkdata_id', $id)->inRandomOrder()->get();;
        // just to add other images to it . that's all 

        if ($fetch_details) {
            return response()->json([
                'status' => 200,
                'data' => $fetch_details,
                'commnet' => $fetch_comment
                // 'other_data' => $fetch_details_others
            ]);
        }
        // if ($fetch_details->isEmpty()   || $fetch_details_others->isEmpty()  ) {
        return response()->json([
            'status' => 404,
            'message' => 'No orders found matching the query.'
        ], 404);
    }
    public function imagestalk(Request $request, $id)
    {
        $request->validate([
            'talkimagesurls' => 'required'
        ]);
        if (auth('sanctum')->check()) {
            $item =  Promotalkdata::find($id);
            $filetitleimage = $request->talkimagesurls;
            $loaditem = $item->talkimages()->create([
                'talkimagesurls' =>   $filetitleimage
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
        ]);
        // if (auth('sanctum')->check()) {
        $items  = new  Promotalkdata;
        $items->user_id = 6;
        // auth()->user()->id;;
        $items->description = $request->description;
        $items->talkid =  rand(1222, 45543);
        $items->user_name = $request->user_name;
        $items->categories = $request->categories;

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
            'data' => 'talk created',
        ]);
        // }
        // return response()->json([
        //     'status' => 500,
        //     'data' => 'User not login '
        // ]);
    }

    public function feedback(Request $request, $itemid)
    {
        $request->validate([
            'name' => 'required',
            'message' => 'required'
        ]);
        $item = Promotalkdata::find($itemid);
        $name = $request->name;
        $message = $request->message;
        $userfeedback = $item->comment()->create([
            'comment' =>   $message,
            'name' => $name
            // $request->itemadsimagesurls
        ]);
        if ($userfeedback) { // checking network is okay............................
            return response()->json([
                'status' => 200,
                'data' => $userfeedback

            ]);
        }
        return response()->json([
            'status' => 500,
            'message' => 'unable to create a feed back'
        ]);
    }
    public function getfeedback($itemid)
    {
        /// get feedback of a post people made to!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $getfeed = Promotalkcomment::where('promotalkdata_id', $itemid)->get();

        if ($getfeed->isEmpty()) {
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
