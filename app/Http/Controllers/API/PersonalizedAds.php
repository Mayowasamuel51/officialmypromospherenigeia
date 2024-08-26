<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Personalizeds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PersonalizedAds extends Controller
{
    // personalized 
    //  making a form first
    // making a payment plan before using personalized ads 
    // display personalized on page...................
    // types of payment to collect , naira , bank transfer 
    public function storeimages(Request $request)
    {
        // check if the person as made payment first ..................................
        $request->validate([
            'description' => 'required',
            'price' => 'required|integer',
            'state' => 'required',
            'local_gov' => 'required',
            'titleImageurl' => 'required'    // thinking if we should allow images or videos 
        ]);

        if (auth('sanctum')->check()) {
            $presonalized = new Personalizeds;
            $presonalized->user_id = auth()->user()->id;
            $presonalized->categories = $request->categories;
            $presonalized->description = $request->description;
            $presonalized->price_range = $request->price;
            $presonalized->state = $request->state;
            $presonalized->local_gov = $request->local_gov;
            $presonalized->itemadsid = rand(999297, 45543);
            $presonalized->user_image = $request->user_image;
            $filetitleimage = $request->file('titleImageurl');
            $folderPath = "public/";
            $fileName =  uniqid() . '.png';
            $file = $folderPath;
            // . $fileName;
            Storage::put($file, $filetitleimage);
            $presonalized->titleImageurl = 'storage/' . $fileName;

            $presonalized->save();
        }
        return response()->json([
            'status' => 500,
            'message' => 'something happend while trying to create a ad  '
        ]);
    }

    public function storevideos(Request $request)
    {
        // check if the person as made payment first ..................................
        $request->validate([
            'categories' => 'required',
            'description' => 'required',
            'price' => 'required|integer',
            'state' => 'required',
            'local_gov' => 'required',
            'titlevideourl' => 'required'    // thinking if we should allow images or videos 
        ]);
    }
}
