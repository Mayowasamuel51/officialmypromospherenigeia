<?php

namespace App\Http\Controllers;

use App\Models\ItemfreeVideosAds;
use Illuminate\Support\Str;

use App\Models\SellerVideos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\HomeVideoResource;
class SellerVideoController extends Controller
{
    //

    public function publicsellervideos($user_name){
              $user_videos =  HomeVideoResource::collection(SellerVideos::where('user_name', $user_name)->get());
        if ($user_videos->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'videos' => $user_videos
        ], 200);
    }
    public function sellerstoriessingle($id, $description)
    {
        $seller_video_one = SellerVideos::find($id);

        if (! $seller_video_one) {
            return response()->json([
                'status' => 404,
                'message' => 'Post not found.'
            ], 404);
        }

        $description = urldecode($description); // still good to decode

        // ✅ Generate slug from the DB description (not the incoming slug)
        $rawSlug = Str::slug(Str::limit($seller_video_one->description, 1000));

        $expectedSlug = ltrim($rawSlug, '-');

        if ($description !== $expectedSlug) {
            return response()->json([
                'status' => 301,
                'redirect' => "/sellerstories/$id/$expectedSlug"
            ]);
        }

        return response()->json([
            'status' => 200,
            'normalads' => $seller_video_one,
            'show_message' => 'video fetched successfully'
        ]);
    }

    public function sellerstories()
    {
        $categories = [
            "Entertainment",
            "Shortlets & Rentals",
            "Residential and Commercial, CNG",
            "Laptops & Accessories",
            "Real Estate",
            "Phones & Tablets",
            "MUMAG CNG Storage System",
            "Fragrances & Perfumes",
            "Skincare & Beauty",
            "Groceries & Essentials",
            "Home Décor",
            "Furniture & Home Items",
            "Women's Swimwear",
            "Kids & Baby Clothing",
            "Women's Lingerie",
            "Women's Dresses",
            "Women's Shoes",
            "Pet Supplies",
            "Men's Shirts",
            "Men's Shoes",
            "Men's Watches",
            "Women's Watches",
            "Women's Bags",
            "Jewelry & Accessories",
            "Vehicle Upgrades",
            "Automotive & Vehicles",
            "Motorcycles",
            "Apartments for Rent",
            "Fashion & Apparel",
            "Sportswear",
            "Luxury Apartments"
        ];

        // Assuming the column is named 'category' (singular)
        // $sellers = SellerVideos::whereIn('categories', $categories)
        //     ->latest()
        //     ->get();gi
        $sellers = SellerVideos::whereIn('categories', $categories)
            ->latest()
            ->get()
            ->shuffle(); // collection method


        if ($sellers->isEmpty()) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong.',
            ]);
        }

        return response()->json([
            'status' => 200,
            'normalads' => $sellers,
        ]);
    }

    // public function sellerstories()
    // {
    //     // Shortlets & Rentals
    //     $sellers = SellerVideos::where('categories', 'Shortlets & Rentals')
    //         ->orWhere('categories', 'Apartments for Rent')
    //         ->Where('categories',"Skincare & Beauty")
    //         // ->limit(19)
    //         // ->inRandomOrder()
    //         ->latest()->get();
    //     if ($sellers->isEmpty()) {
    //         return response()->json([
    //             'status' => 500,
    //             'messages' => 'something went worng',
    //             // 'local_gov' => $homepagerender_local_gov
    //         ]);
    //     }
    //     return response()->json([
    //         'status' => 200,
    //         'normalads'  =>  $sellers,
    //     ]);
    // }
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
                $video = SellerVideos::create(attributes: [
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
