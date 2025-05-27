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
         $categories = [
            "Shortlets & Rentals", // updated for clarity
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
        // Shortlets & Rentals
        $sellers = SellerVideos::whereIn('categories', $categories)
        //   ->orWhere('categories', 'Apartments for Rent')->orWhere('categories','Phones & Tablets')
        // ->Where("Skincare & Beauty")
        // ->limit(19)
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
