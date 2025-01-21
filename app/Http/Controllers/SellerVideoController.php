<?php

namespace App\Http\Controllers;

use App\Models\ItemfreeVideosAds;
use App\Models\SellerVideos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SellerVideoController extends Controller
{
    //
    public function  sellerstoriessingle($id){
        $sellers = SellerVideos::where('id', $id)
        ->get();
        if ($sellers->isEmpty()) {
            return response()->json([
                'status' => 500,
                'messages' => 'something went worng cant find video',
                // 'local_gov' => $homepagerender_local_gov
            ]);
        }
        return response()->json([
            'status' => 200,
            'normalads'  =>  $sellers,
        ]);

    }
    public function sellerstories()
    {
        // Shortlets & Rentals
        $sellers = SellerVideos::where('categories', 'Shortlets & Rentals')
        // ->Where("Laptops & Accessories")
        // ->Where("Skincare & Beauty")
        ->limit(5)
        ->latest()->get();
        if ($sellers->isEmpty()) {
            return response()->json([
                'status' => 500,
                'messages' => 'something went worng',
                // 'local_gov' => $homepagerender_local_gov
            ]);
        }
        return response()->json([
            'status' => 200,
            'normalads'  =>  $sellers,
        ]);
    }
    public function videoupload(Request $request)
    {
        $request->validate([
            // 'categories' => 'required',
            // 'description' => 'required',
            // 'price_range' => 'required|integer',
            // 'state' => 'required',
            // 'local_gov' => 'required',
            // 'titleImageurl' => 'required',
            // 'titlevideourl' => 'required'
        ]);

        if (auth('sanctum')->check()) {
            $value = 1;
            // $filetitleimage = $request->file('thumbnails');
            // $folderPath = "public/";
            // $fileName =  uniqid() . '.png';
            // $file = $folderPath;
            // $mainfile =    Storage::put($file, $filetitleimage);
            SellerVideos::create([
                "user_id" => auth()->user()->id,
                'categories' => $request->categories,
                'description' => $request->description,
                'state' => $request->state,
                'local_gov' => $request->local_gov,
                // 'itemadsid' => rand(999297, 45543),
                // 'thumbnails' => $mainfile,
                'titlevideourl' => $request->titlevideourl,
                'user_name' => $request->user_name,
                // 'aboutMe'=>$request->aboutMe
                // 'freetimes'=>$value
            ]);
            // $user_update_free_times = new User;
            // $user_update_free_times->freetimes = $value;
            // $user_update_free_times->update();
            // if ($items) {
            //     if (auth()) {
            //         $affected = DB::table('users')->increment('freetimes');
            //         //  DB::table('users')
            //         //     ->where('id', auth()->user()->id)
            //         //     ->update(['freetimes' => $value]);
            //         return response()->json([
            //             'status' => 201,
            //             'check' =>  $affected,
            //             'message' => 'items ads created'
            //         ]);
            //     }
            // }
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
}
