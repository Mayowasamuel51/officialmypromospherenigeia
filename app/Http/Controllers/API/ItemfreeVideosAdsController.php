<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ItemfreeAds;
use App\Models\ItemfreeVideosAds;
use App\Models\ItemsAds;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemfreeVideosAdsController extends Controller
{
    //
    public function freeLimitedAds(Request $request)
    {
        // the freelimited ad will only allow 15  per new account to post noramls ads and video ads 
        // we need to count the times it was used 
        // every post == 1 eliter noraml post or videos post 
        $request->validate([
            'categories' => 'required',
            // 'description' => 'required',
            // 'price_range' => 'required|integer',
            // 'state' => 'required',
            // 'local_gov' => 'required',
            // 'headlines' => 'required',
            'titlevideourl' => 'required'
        ]);
        // check if free times is more than 20 times 
        // check the current time stage ( meaning how many left)
        if (auth('sanctum')->check()) {
            if (auth()->user()->current_plan  === 'freeplan') {
                if (auth()->user()->freetimes >= 5100) {
                    return response()->json([
                        'status' => 500,
                        'message' => 'sorry you cant post again , please upgrade to paid plan '
                    ]);
                }
                $value = 1;

                $filetitleimage = $request->file('thumbnails');
                $folderPath = "public/";
                $fileName =  uniqid() . '.png';
                $file = $folderPath;
                $mainfile =    Storage::put($file, $filetitleimage);
                $items  = ItemfreeVideosAds::create([

                    "user_id" => auth()->user()->id,
                    'categories' => $request->categories,
                    'description' => $request->description,
                    'price_range' => $request->price_range,
                    'productName' => $request->productName,
                    'state' => $request->state,
                    'local_gov' => $request->local_gov,
                    'headlines' => $request->headlines,
                    'itemadsid' => rand(999297, 45543),
                    'thumbnails' => $mainfile,
                    'usedOrnew' => $request->usedOrnew,
                    'titlevideourl' => $request->titlevideourl,
                    'whatapp' => $request->whatapp,
                    'user_phone' => $request->user_phone,
                    'user_name' => $request->user_name,
                    'discount' => $request->discount,
                    // 'aboutMe'=>$request->aboutMe
                    // 'freetimes'=>$value
                ]);
                // $user_update_free_times = new User;
                // $user_update_free_times->freetimes = $value;
                // $user_update_free_times->update();
                if ($items) {
                    if (auth()) {
                        $affected = DB::table('users')->increment('freetimes');
                        //  DB::table('users')
                        //     ->where('id', auth()->user()->id)
                        //     ->update(['freetimes' => $value]);
                        return response()->json([
                            'status' => 201,
                            'check' =>  $affected,
                            'message' => 'items ads created'
                        ]);
                    }
                }
                return response()->json([
                    'status' => 500,
                    'message' => 'something happend while trying to create a ad  '
                ]);
            }
            return response()->json([
                'status' => 500,
                'message' => 'Sorry you have finshed your free ads   '
            ]);
        }
        return response()->json([
            'status' => 401,
            'message' => 'not allowed  '
        ]);
    }
}
