<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Nofications;
use App\Models\Promotalkdata;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
// use Illuminate\Notifications\Notification;

class PromoTalkLikeController extends Controller
{
    public function storeToken(Request $request)
    {
        // $request->validate([
        //     'fcm_token' => 'required|string',
        //     'user_id' => 'required|exists:users,id',  // Ensure the user exists
        // ]);

        $send_nofication = new    Nofications;
        $send_nofication->user_id = 4;
        $send_nofication->fcm_token = $request->fcm_token;

        $send_nofication->save();


        return response()->json(['message' => 'FCM Token saved successfully']);
    }


    public function sendNotification(Request $request,$user_id)
    {
        // Get the FCM token from the request (You should already have the token stored in your DB)
        // $fcmToken = $request->input('fcm_token'); // Or fetch it from the database

        $userId = $request->input($user_id);

        // Fetch the FCM token from the database
        $fcmToken = Nofications::where('user_id', $userId)->value('fcm_token');

        $title = "Test Notification";
        $body = "This is a test notification from your backend!";

        // Prepare the notification data
        $data = [
            'to' => $fcmToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'icon' => 'https://example.com/your-icon.png', // Optional
            ],
        ];

        // FCM Server Key (Get this from your Firebase Console)
        $serverKey = "BDtAKIAnq742og964l2dF4uBcKxJ8MlK9uXfjqKgD5bfdlKtVC6NB4ny341RQ6HUTJjIXoQj_Ini9m4D-K4THi8"; // Replace with your actual server key

        try {
            $client = new Client();
            $response = $client->post('https://fcm.googleapis.com/fcm/send', [
                'headers' => [
                    'Authorization' => 'key=' . $serverKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);

            // Get the response body for more details
            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Check if the notification was successfully sent
            if (isset($responseBody['success']) && $responseBody['success'] > 0) {
                return response()->json(['message' => 'Notification sent successfully!'], 200);
            } else {
                return response()->json([
                    'message' => 'Failed to send notification',
                    'details' => $responseBody
                ], 500);
            }
        } catch (\Exception $e) {
            // Log error for troubleshooting
            \Log::error('Error sending notification: ' . $e->getMessage());
            return response()->json(['error' => 'Error sending notification'], 500);
        }
    }



    public function sendNot(Request $request,$user_id)
    {
        // Get the FCM token from the request (You should already have the token stored in your DB)
        // $fcmToken = $request->input('fcm_token'); // Or fetch it from the database

        $userId = $request->input($user_id);

        // Fetch the FCM token from the database
        $fcmToken = Nofications::where('user_id', $userId)->value('fcm_token');

        $title = "Test Notification";
        $body = "This is a test notification from your backend!";

        // Prepare the notification data
        $data = [
            'to' => $fcmToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'icon' => 'https://example.com/your-icon.png', // Optional
            ],
        ];

        // FCM Server Key (Get this from your Firebase Console)
        $serverKey = "BDtAKIAnq742og964l2dF4uBcKxJ8MlK9uXfjqKgD5bfdlKtVC6NB4ny341RQ6HUTJjIXoQj_Ini9m4D-K4THi8"; // Replace with your actual server key

        try {
            $client = new Client();
            $response = $client->post('https://fcm.googleapis.com/fcm/send', [
                'headers' => [
                    'Authorization' => 'key=' . $serverKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);

            // Get the response body for more details
            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Check if the notification was successfully sent
            if (isset($responseBody['success']) && $responseBody['success'] > 0) {
                return response()->json(['message' => 'Notification sent successfully!'], 200);
            } else {
                return response()->json([
                    'message' => 'Failed to send notification',
                    'details' => $responseBody
                ], 500);
            }
        } catch (\Exception $e) {
            // Log error for troubleshooting
            \Log::error('Error sending notification: ' . $e->getMessage());
            return response()->json(['error' => 'Error sending notification'], 500);
        }
    }




    public function totallikes($itemid)
    {
        $total = Promotalkdata::find($itemid);
        $userfeedback = $total->likestalks()->where('item_id', 1)->count();

        return response()->json([
            'status' => 200,
            'data' => $userfeedback
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
                // ->where('item_id', 1)
                // ->where('item_id', $itemid)
                ->delete();

            return response()->json(['message' => 'Disliked successfully.'], 200);
        }
        // $like = Like::where('user_id', $validated['user_id'])
        //     ->where('item_id', $validated['item_id'])
        //     ->delete();

        // Send notification to the item owner
        // $this->sendNotification($validated['user_id'], 'disliked your item.');

        // return response()->json(['message' => 'Disliked successfully.'], 200);
    }































    // private function sendNotification($userId, $message)
    // {
    //     $user = User::find($userId);

    //     // Push notification logic
    //     // Example: FCM, Pusher, or Laravel Notifications
    //     $user->notify(new \App\Notifications\ItemLikedNotification($message));
    // }
}
