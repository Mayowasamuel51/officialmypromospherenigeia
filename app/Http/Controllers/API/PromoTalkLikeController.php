<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Promotalkdata;
use App\Models\User;
use Illuminate\Http\Request;

class PromoTalkLikeController extends Controller
{

    public function totallikes($itemid){
        $total = Promotalkdata::find($itemid);
        $userfeedback = $total->likestalks()->where('item_id', 1)->count();

        return response()->json([
            'status'=>200,
            'data'=>$userfeedback
        ]);
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
    // private function sendNotification($userId, $message)
    // {
    //     $user = User::find($userId);

    //     // Push notification logic
    //     // Example: FCM, Pusher, or Laravel Notifications
    //     $user->notify(new \App\Notifications\ItemLikedNotification($message));
    // }
}

