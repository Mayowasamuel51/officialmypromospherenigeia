<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Resources\PromoTalk as ResourcesPromoTalk;
use App\Models\Like;
use App\Models\Promotalkcomment;
use App\Models\Promotalkdata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromoTalk extends Controller
{


    // public function promotalksingle($id, $description)
    // {
    //     // Fetch post by ID
    //     $fetch_details = Promotalkdata::with('comment')->find($id);

    //     // If post not found
    //     if (!$fetch_details) {
    //         return response()->json([
    //             'status' => 404,
    //             'message' => 'Post not found.'
    //         ], 404);
    //     }

    //     // Generate the expected slug from the description (limit for very long content)
    //     // $expectedSlug = Str::slug(Str::limit($fetch_details->description, 6990));
    //     // $expectedSlug = Str::slug(Str::limit($fetch_details->description, 6990));
    //     $rawSlug = Str::slug(Str::limit($fetch_details->description, 40000));

    //     // Remove leading dashes
    //     $expectedSlug = ltrim($rawSlug, '-');

    //     // Redirect if slug doesn't match the description in URL
    //     if ($description !== $expectedSlug) {
    //         return response()->json([
    //             'status' => 301,
    //             'redirect' => "/mypromotalk/{$id}/{$expectedSlug}"
    //         ]);
    //     }

    //     // Randomize comments if needed
    //     $fetch_comment = $fetch_details->comment->shuffle();

    //     return response()->json([
    //         'status' => 200,
    //         'data' => $fetch_details,
    //         'show_message' => 'Post fetched successfully',
    //         'comment' => $fetch_comment
    //     ]);
    // }

    public function promotalksingle($id, $description)
    {
        // Fetch post by ID
        $fetch_details = Promotalkdata::find($id);

        // If post not found
        if (!$fetch_details) {
            return response()->json([
                'status' => 404,
                'message' => 'Post not found.'
            ], 404);
        }

        // Check if slug matches (optional but good practice)
        // $expectedSlug = Str::slug(substr($fetch_details->description,0,6990));
        $rawSlug = Str::slug(Str::limit($fetch_details->slug, 100000));

        // Remove leading dashes
        $expectedSlug = ltrim($rawSlug, '-');
        if ($description !== $expectedSlug) {
            return response()->json([
                'status' => 301,
                'redirect' => "/mypromotalk/$id/$expectedSlug"
            ]);
        }

        // Fetch related comments
        // $fetch_comment = $fetch_details->comment()->inRandomOrder()->get();
        $fetch_comment = Promotalkdata::find($id)->comment()->where('promotalkdata_id', $id)->inRandomOrder()->get();

        return response()->json([
            'status' => 200,
            'data' => $fetch_details,
            'show_message' => 'Post fetched successfully',
            'comment' => $fetch_comment
        ]);
    }

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
            Promotalkdata::withCount('comment') // Adds comments_count to each post
                ->latest()
                ->get()
        );

        if ($promotalk->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'data'   => $promotalk
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No posts found matching the query.'
        ], 404);
    }
    public function promotalk()
    {
       $promotalk = ResourcesPromoTalk::collection(
    Promotalkdata::withCount('comment')
        ->latest()
        ->take(50) // grab the latest 50
        ->inRandomOrder() // shuffle them randomly
        ->get()
);

        if ($promotalk->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'data'   => $promotalk
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No posts found matching the query.'
        ], 404);
    }



    // public function  promotalk()
    // {
    //     $promotalk = ResourcesPromoTalk::collection(

    //         DB::table('promotalkdatas')
    //             ->latest()
    //             ->get()
    //         // ->inRandomOrder()
    //         // ->paginate(30)
    //     );
    //     if ($promotalk) {
    //         return response()->json([
    //             'status' => 200,
    //             'data'  =>  $promotalk
    //         ]);
    //     }
    //     return response()->json([
    //         'status' => 404,
    //         'message' => 'No orders found matching the query.'
    //     ], 404);
    // }
    // public function promotalksingle($id, $description)
    // {
    //     // display the commnet made one this post 

    //     $fetch_details  = Promotalkdata::where('id', $id)->where('description', $description)->first();
    //     // Promotalkdata::find($id);
    //     // / $fetch_details->talkimages->where('promotalkdata_id', $id)->get();
    //      $expectedSlug = Str::slug($fetch_details->description);
    //     $fetch_comment = Promotalkdata::find($id)->comment()->where('promotalkdata_id', $id)->inRandomOrder()->get();;
    //     // just to add other images to it . that's all 

    //     if ($fetch_details) {
    //         return response()->json([
    //             'status' => 200,
    //             'data' => $fetch_details,
    //             "show message" => "working here",
    //             'commnet' => $fetch_comment
    //             // 'other_data' => $fetch_details_others
    //         ]);
    //     }
    //     // if ($fetch_details->isEmpty()   || $fetch_details_others->isEmpty()  ) {
    //     return response()->json([
    //         'status' => 404,
    //         'message' => 'No orders found matching the query.'
    //     ], 404);
    //     // }

    // }

    public function promotalksidebarsingle($id, $description)
    {
        $fetch_details = Promotalkdata::find($id);

        // If post not found
        if (!$fetch_details) {
            return response()->json([
                'status' => 404,
                'message' => 'Post not found.'
            ], 404);
        }

        // Check if slug matches (optional but good practice)
        $expectedSlug = Str::slug($fetch_details->description);
        if ($description !== $expectedSlug) {
            return response()->json([
                'status' => 301,
                'redirect' => "/mypromotalk/$id/$expectedSlug"
            ]);
        }

        // Fetch related comments
        // $fetch_comment = $fetch_details->comment()->inRandomOrder()->get();
        $fetch_comment = Promotalkdata::find($id)->comment()->where('promotalkdata_id', $id)->inRandomOrder()->get();

        return response()->json([
            'status' => 200,
            'data' => $fetch_details,
            'show_message' => 'Post fetched successfully',
            'comment' => $fetch_comment
        ]);
        // $fetch_details  = Promotalkdata::find($id);
        // // / $fetch_details->talkimages->where('promotalkdata_id', $id)->get();
        // $fetch_comment = Promotalkdata::find($id)->comment()->where('promotalkdata_id', $id)
        //     // ->inRandomOrder()
        //     ->get();;
        // // just to add other images to it . that's all 

        // if ($fetch_details) {
        //     return response()->json([
        //         'status' => 200,
        //         'data' => $fetch_details,
        //         'commnet' => $fetch_comment
        //         // 'other_data' => $fetch_details_others
        //     ]);
        // }
        // // if ($fetch_details->isEmpty()   || $fetch_details_others->isEmpty()  ) {
        // return response()->json([
        //     'status' => 404,
        //     'message' => 'No orders found matching the query.'
        // ], 404);
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
    $id = random_int(1000000000, 9999999999);

    $request->validate([
        'description' => 'required',
    ]);

    $items = new Promotalkdata;

    // Generate slug
    $slug = Str::slug($request->description);
    $count = Promotalkdata::where('slug', $slug)->count();
    if ($count > 0) {
        $slug .= '-' . date('ymdis') . '-' . rand(0, 999);
    }

    $items->random     = $id;
    $items->slug       = $slug;
    $items->description = $request->description;
    $items->talkid     = rand(1222, 45543);
    $items->categories = $request->categories;
    $defaultNames = [
    'CoolUser',
    'Guest',
    'Somebody',
    'MysteryPerson',
    'RandomDude',
    'HiddenGem',
    'Stranger',
    'AnonCat',
    'GhostRider',
    'SecretUser'
];
$randomName = $defaultNames[array_rand($defaultNames)] . rand(10, 999);
    if (auth('sanctum')->check()) {
        // Logged in user
        $items->user_id   = auth()->id();
        $items->user_name = auth()->user()->name ?? $request->user_name;
    } else {
        // Guest post
        $items->user_id   = null;
        $items->user_name = $request->user_name ?? $randomName;
    }

    // Handle image upload if provided
    if ($request->hasFile('titleImageurl')) {
        $manager = new ImageManager(new Driver());
        $image_one = $request->file('titleImageurl');
        $image_one_name = hexdec(uniqid()) . '.' . strtolower($image_one->getClientOriginalExtension());

        $image = $manager->read($image_one);
        $final_image = 'promotalkimages/images/' . $image_one_name;
        $image->save($final_image);

        $items->titleImageurl = $final_image;
    }

    $items->save();

    return response()->json([
        'status' => 200,
        'item'   => $items->id,
        'data'   => 'talk created',
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
            'active' => 1,
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
        $getfeed = Promotalkcomment::where('promotalkdata_id', $itemid)->latest()->get();

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


    public function totalcomment($itemid)
    { {
            /// Making total comment for talk 
            $total = Promotalkdata::find($itemid);
            $userfeedback = $total->comment()->where('active', 1)->count();

            return response()->json([
                'status' => 200,
                'data' => $userfeedback
            ]);
        }
    }

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
        if ($itemPromotalkdata->likestalks()->where('user_id', auth()->user()->id)->exists()) {
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
        if ($itemPromotalkdata->likestalks()->where('user_id', auth()->user()->id)->exists()) {
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


    public function totallikes($itemid)
    {
        $total = Promotalkdata::find($itemid);
        $userfeedback = $total->likestalks()->where('active', 1)->count();
        return response()->json([
            'status' => 200,
            'data' => $userfeedback
        ]);
    }
}
