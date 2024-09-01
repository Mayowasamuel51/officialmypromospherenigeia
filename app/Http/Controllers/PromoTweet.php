<?php

namespace App\Http\Controllers;

use App\Http\Resources\PromoTweet as ResourcesPromoTweet;
use App\Models\PromoTweet as ModelsPromoTweet;
use App\Models\PromoTweetcomment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PromoTweet extends Controller{
    public function searchTweet($tweet){
        /// will be searching for tweet , we can take from that categoris 
    }

    public function selectingTweet($categories)
    {
        /// this will be a select box to switch in between tweets 
        // $categories = [
        //     "shortlet",

        //     "Laptops",

        //     "Property",

        //     "Phones, Tablets",

        //     "Fragrances",

        //     "Skincare",

        //     "Groceries",

        //     "home-decoration",

        //     "FurnitureTweet ",

        //     "Womens bikins",

        //     "Kids , Baby dresses",

        //     "Womens under waress",

        //     "womens-dresses",

        //     "womens-shoes",

        //     "Pets",

        //     "Mens-shirts",

        //     "Mens-shoes",

        //     "Mens-watches",

        //     "Womens-watches",

        //     "Womens-bags",

        //     "Womens-jewellery",

        //     "Vehicles Upgrade",

        //     "Automotive , Vehicles",

        //     "Motorcycle",

        //     "Apartment",

        //     "Fashion",  /// on we put Fashion

        //     "Sport DressesTweet",


        //     "Luxury-apartmentTweet"
        // ];
        $promotalk = ResourcesPromoTweet::collection(
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

    public function lastestTweet()
    {
        // this could be about  , Poperty , apartment , hair , skincare , coding , 
        $promotalk = ResourcesPromoTweet::collection(

            DB::table('promo_tweets')
                // ->orWhere('categories', 'like', '%product%')
                // ->orWhere('categorie', 'like', '%land%')->orWhere('categorie', 'like', '%youtude%')->orWhere('categorie', 'like', '%developer%')->orWhere('categorie', 'like', '%knack%')->orWhere('categorie', 'like', '%knacking%')
                // ->orWhere('categorie', 'like', '%facebook%')
                // ->orWhere('categorie', 'like', '%lover%')
                // ->where('categorie', 'like', '%sex%')
                // ->orWhere('categorie', 'like', '%help%')
                ->orWhere('categories', 'like', '%FurnitureTweet%')
                ->orWhere('categories', 'like', '%Apartment%')
                // ->orWhere('categorie', 'like', '%fuck%')
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

    public function lastestTweetsingle($id)
    {
        $fetch_details  = ModelsPromoTweet::find($id);
        // just to add other images to it . that's all 
        // $fetch_details->talkimages->where('promotalkdata_id', $id)->get();
        $fetch_comment  =  ModelsPromoTweet::find($id)->tweetcomment()->where('promo_tweet_id', $id)->inRandomOrder()->get();;
        if ($fetch_details) {
            return response()->json([
                'status' => 200,
                'data' => $fetch_details,
                'comments' => $fetch_comment
            ]);
        }
        // if ($fetch_details->isEmpty()   || $fetch_details_others->isEmpty()  ) {
        return response()->json([
            'status' => 404,
            'message' => 'No orders found matching the query.'
        ], 404);
        // }

    }
    public function  promotweet()
    {
        // we need to display the user pic too 
        // show the total comment for each tweet this will be people click on it just twittwer
        $promotweet = ResourcesPromoTweet::collection(
            DB::table('promo_tweets')
                // ->where('cat') add the categoies to this for filter the tweet pages
                ->inRandomOrder()
                ->get()
        );
        // $total_comment = 
        if ($promotweet->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data'  =>  $promotweet
        ]);
       
    }

    public function promotweetsingle($id)
    {
        $fetch_details  = ModelsPromoTweet::find($id);
        // just to add other images to it . that's all 
        // $fetch_details->talkimages->where('promotalkdata_id', $id)->get();
        $fetch_comment  =  ModelsPromoTweet::find($id)->tweetcomment()->where('promo_tweet_id', $id)->inRandomOrder()->get();;
        if ($fetch_details) {
            return response()->json([
                'status' => 200,
                'data' => $fetch_details,
                'comments' => $fetch_comment
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
            'itemadsimagesurls' => 'required'
        ]);
        // if (auth('sanctum')->check()) {
            $item =   ModelsPromoTweet::find($id);
            $filetitleimage = $request->talkimagesurls;
            $loaditem = $item->tweetimages()->create([
                'itemadsimagesurls' =>   $filetitleimage
            ]);
            if ($loaditem) { // checking network is okay............................
                return response()->json([
                    'message' => $loaditem
                ]);
            }
        // }
        // return response()->json([
        //     'status' => 401,
        //     'message' => 'You are not unauthenticated Procced to login or register '
        // ]);
    }

    public function makepost(Request $request)
    {
        // this , you can add images to this post as a users 
        $request->validate([
            'description' => 'required',
            // 'title' => 'required'
        ]);
        // if (auth('sanctum')->check()) {
        $items  = new  ModelsPromoTweet;
        $items->user_id = 6;
        // auth()->user()->id;;

        $items->description = $request->description;
        $items->talkid =  rand(1222, 45543);
        $items->user_name = $request->user_name;
        $items->title = $request->title;
        $items->user_image = $request->user_image;
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
            'data' => 'tweet created',
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
        $item = ModelsPromoTweet::find($itemid);
        $name = $request->name;
        $message = $request->message;
        $userfeedback = $item->tweetcomment()->create([
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
        $getfeed = PromoTweetcomment::where('promo_tweet_id', $itemid)->get();

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
