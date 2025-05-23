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
    public function  sellerstoriessingle($id)
    {
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
            ->orWhere('categories', 'Apartments for Rent')
            // ->Where("Skincare & Beauty")
            ->limit(19)
            // ->inRandomOrder()
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
            // 'state' => 'required',
            // 'local_gov' => 'required',
            // 'titlevideourl' => 'required',
            // 'user_name' => 'required',
        ]);

        if (auth('sanctum')->check()) {
            $user = auth()->user();
            if ($user) {
                $video = SellerVideos::create([
                    "user_id" => $user->id,
                    'categories' => $request->categories,
                    'description' => $request->description,
                    'state' => $request->state,
                    'local_gov' => $request->local_gov,
                    'titlevideourl' => $request->titlevideourl,
                    'user_name' => $request->user_name,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Video uploaded successfully',
                    'data' => $video
                ]);
            }

            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong while trying to create an ad'
            ]);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Unauthorized'
        ]);
    }
}
