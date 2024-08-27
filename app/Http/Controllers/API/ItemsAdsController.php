<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ItemsAds;
use App\Models\User;
use Illuminate\Http\Request;

class ItemsAdsController extends Controller
{
    //


    public function ItemsAdsStore(Request $request, User $usercurrentplan)
    {
        // if the user as not paid for any plan the user wont be allowed to create  itemAds or any Ads 
        // check of the date_buy_count and current_plan they are on before the server allows them to create a ad 
        // two types of plan PlanA OR PlanB   

        $request->validate([
            'categories' => 'required',
            'description' => 'required',
            'price_range' => 'required|integer',
            'state' => 'required',
            'local_gov' => 'required',
            'headlines' => 'required',
            'titleImageurl' => 'required'
        ]);

        if (auth('sanctum')->check()) {
            $check_current_plan =  User::where('current_plan',   auth()->user()->current_plan)->get();
            // return response()->json([
            //     'status' => 201,
            //     'message' => $check_current_plan
            // ]);
            if (auth()->user()->current_plan  === 'planA' || auth()->user()->current_plan  === 'planB') {
                $items  = ItemsAds::create([
                    "user_id" => auth()->user()->id,
                    'categories' => $request->categories,
                    'description' => $request->description,
                    'price_range' => $request->price,
                    'state' => $request->state,
                    'local_gov' => $request->local_gov,
                    'headlines' => $request->headlines,
                    'itemadsid' => rand(999297, 45543),
                    'usedOrnew' => $request->usedOrnew,
                    'titleImageurl' => $request->titleImageurl
                ]);
                if ($items) {
                    return response()->json([
                        'status' => 201,
                        'message' => 'items ads created'
                    ]);
                }
                return response()->json([
                    'status' => 500,
                    'message' => 'something happend while trying to create a ad  '
                ]);
            }
            return response()->json([
                'status' => 500,
                'message' => 'Sorry you dont have a plan   '
            ]);
        }
    }
}
