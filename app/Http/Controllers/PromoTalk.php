<?php
namespace App\Http\Controllers;

use App\Http\Resources\PromoTalk as ResourcesPromoTalk;
use App\Models\Like;
use App\Models\Promotalkcomment;
use App\Models\Promotalkdata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PromoTalk extends Controller
{

    public function selectingTalk($categories)
    {
        /// this will be a select box to switch in between tweets 
        // $categories = [
        //     'sex',
        //     'products',
        //     'online market place',
        //     "politics",
        //     "economy",
        //     "entertainment",
        //     "education",
        //     "sports",
        //     "love",
        //     "health",
        //     "religion",
        //     "technology",
        //     "culture",
        //     "relationships",
        //     "career",
        //     "fashion",
        //     "business",
        //     "social media",
        //     "music",
        //     "movies",
        //     "food",
        //     "travel",
        //     "real estate",
        //     "entrepreneurship"
        // ];
        $promotalk =  ResourcesPromoTalk::collection(
            DB::table('promotalkdatas')
                ->where('categories', $categories)
                ->get()
        );

        if ($promotalk->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data'  =>  $promotalk
        ]);
        
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
                ->orWhere('description', 'like', '%help%')  ->orWhere('description', 'like', '%Pussy%')
                ->orWhere('description', 'like', '%pussy%')
                ->orWhere('description', 'like', '%lover%')  ->orWhere('description', 'like', '%Ladies%')
                ->orWhere('description', 'like', '%lady%')  ->orWhere('description', 'like', '%Lady%')
                ->orWhere('description', 'like', '%fuck%')  ->orWhere('description', 'like', '%Sex%')
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
                // ->orWhere('description', 'like', '%lady%')
                // ->orWhere('description', 'like', '%fuck%')
                // ->orWhere('description', 'like', '%football%')
                // ->inRandomOrder()chrome
                // ->get()
                // ->latest()
                // ->get()
                ->inRandomOrder()
                ->paginate(30)
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
        $fetch_comment = Promotalkdata::find($id)->comment()->where('promotalkdata_id', $id)
        // ->inRandomOrder()
        ->get();;
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
        $nince =1;
        if (auth('sanctum')->check()) {
        $items  = new  Promotalkdata;
        $items->user_id = auth()->user()->id;;
        $items->description = $request->description;
        $items->talkid =  rand(1222, 45543);
        $items->user_name = $request->user_name;
        $items->categories = $request->categories;

        $filetitleimage = $request->file('titleImageurl');
        // if($filetitleimage)
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
        }
        return response()->json([
            'status' => 500,
            'data' => 'User not login '
        ]);
    }

    public function feedback(Request $request, $itemid)
    {
        $request->validate([
            // 'name' => 'required',
            'message' => 'required'
        ]);
        $item = Promotalkdata::find($itemid);

        $name = $request->name;

        $message = $request->message;

        $userfeedback = $item->comment()->create([
            'comment' =>   $message,
            'active'=>1,
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


    public function totalcomment ($itemid){{
        /// Making total comment for talk 
        $total = Promotalkdata::find($itemid);
        $userfeedback = $total->comment()->where('active', 1)->count();

        return response()->json([
            'status'=>200,
            'data'=>$userfeedback
        ]);

    }}

    public function like(Request $request, $itemid)
    {
        // auth()->user()->id ;
        $validated = $request->validate([
            // 'user_id' => 'required|exists:users,id',
            // 'item_id' => 'required',
        ]);
        $itemPromotalkdata  = Promotalkdata::find($itemid);
        if (!$itemPromotalkdata) {
            return response()->json(['message' => 'Talk  not found.'], 404);
        }

        // $userId = auth()->user()->id;

        // // Check if the user already liked this item
        if ($itemPromotalkdata->likestalks()->where('user_id', auth()->user()->id)->exists() ) {
            return response()->json(['message' => 'Already liked.'], 400);
        } 
        $uselikes = $itemPromotalkdata->likestalks()->create([
            'item_id' => 1,
            'user_id' => auth()->user()->id
        ]);

        //send user the nofication 
        // Send notification to the item owner
        // $this->sendNotification(auth()->user()->name, 'liked your item.');

        return response()->json(['message' => 'Liked successfully.'], 200);
    }

    public function dislike(Request $request, $itemid)
    {
        // $validated = $request->validate([
        //     'user_id' => 'required|exists:users,id',
        //     'item_id' => 'required',
        // ]);

        $itemPromotalkdata  = Promotalkdata::find($itemid);
        if (!$itemPromotalkdata) {
            return response()->json(['message' => 'Talk  not found.'], 404);
        }

        // $userId = auth()->user()->id;

        // // making the user dislike the talk 
        if ($itemPromotalkdata->likestalks()->where('user_id', auth()->user()->id)->exists() ) {
            // return response()->json(['message' => 'Already liked.'], 400);
            // delete it 
            Like::where('user_id', auth()->user()->id)
                ->where('item_id', 1)
                ->delete();

            return response()->json(['message' => 'Disliked successfully.'], 200);

        } 
        // $like = Like::where('user_id', $validated['user_id'])
        //     ->where('item_id', $validated['item_id'])
        //     ->delete();

        // Send notification to the item owner
        // $this->sendNotification($validated['user_id'], 'disliked your item.');

        return response()->json(['message' => 'Disliked successfully.'], 200);
    }


    public function totallikes($itemid){
        $total = Promotalkdata::find($itemid);
        $userfeedback = $total->likestalks()->where('active', 1)->count();
        return response()->json([
            'status'=>200,
            'data'=>$userfeedback
        ]);
    }
}
