<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\HomePageControllerResource;
use App\Http\Resources\HomeVideoResource;
use App\Models\ItemfreeAds;
use App\Models\ItemfreeVideosAds;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller{
    public function personalUploads($id){
        // if ($userUploads->isEmpty()||$userUploadsVideo->isEmpty()||$userUploads->count(  )=== 0|| $userUploadsVideo->count(  )=== 0 ) {
        //     return response()->json([
        //         'status' => 404,
        //         'message' => 'No orders found matching the query.'
        //     ], 404);
        // }
        if (auth('sanctum')->check()) {
            // a user has many uploads 
            // ->itemuserimages()->where('user_id', $id)->latest()->get();
        
            $userUploadsPost =  User::find($id)->itemuserimages()->where('user_id', $id)->latest()->get();
            if($userUploadsPost ->isEmpty()  ){
                return response()->json([
                    'status' => 404,
                    'message' => 'No orders found matching the query.'
                ], 404);
       
            }
            return response()->json([
                'status' => 200,
                'posts' =>$userUploadsPost,
                
            ]);
        }
     
    }

    public function personalVideos($id){
                $userUploadsVideo =  User::find($id)->itemuserivideo()->where('user_id', $id)->latest()->get();
                if(  $userUploadsVideo->isEmpty() ){
                    return response()->json([
                        'status' => 404,
                        'message' => 'No orders found matching the query.'
                    ], 404);
           
                }
                return response()->json([
                    'status' => 200,
        
                    'posts'=>$userUploadsVideo
                ]);
    }
    public function updateuserinfo(Request $request, $iduser){
        $validator = Validator::make($request->all(), [
            // 'profileImage' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $all_data = $request->all();
            if (auth('sanctum')->check()) {
                $user_infomation = User::findOrFail($iduser);
                if ($user_infomation) {
             
                    $user_infomation->profileImage =   $request->profileImage;    

                    $user_infomation->websiteName = $request->websiteName;
                    $user_infomation->messageCompany = $request->messageCompany;

                    $user_infomation->aboutMe = $request->aboutMe;
                    $user_infomation->brandName = $request->brandName;

                    $user_infomation->whatapp= $request->whatapp;
                    $user_infomation->user_phone = $request->user_phone;

                    $user_infomation->user_social =$request->user_social;
               
                    $user_infomation->save(); 
                    
                    // return response()->json([
                    //     'status'=>200,
                    //     'updated' => $user_infomation
                    // ]);
                    return response()->json([
                        'status' => 200,
                        'updated' => $user_infomation
                    ]);
                }

            }
        }
    }

    public function updatebackgroundimage(Request $request, $iduser){
        $validator = Validator::make($request->all(), [
            // 'profileImage' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $all_data = $request->all();
            if (auth('sanctum')->check()) {
                $user_infomation = User::findOrFail($iduser);
                if ($user_infomation) {
                    $user_infomation->backgroundimage = $request->backgroundimage;
                    $user_infomation->save();     
                    return response()->json([
                        'status' => 200,
                        'updated' => $user_infomation
                    ]);
                }

            }
        }
    }
    public function settings($id){
        $user  = User::where('id',$id)->get();
        // findOrFail($id);
        if (auth('sanctum')->check()) {
            if($user->isEmpty()){
                return response()->json([
                    'status' => 404,
                    'message' => 'Please login or register '
                ], 404);
            }
            return response()->json([
                'status' => 200,
                'data' => $user
            ]);
        }
    }

    public function profileUserPost($id){
        // $user = User::where('id',$id)->get();  .i chnage the user_id to user_name 
        $user_infomation = HomePageControllerResource::collection(ItemfreeAds::where('user_name',$id)->get());
        if( $user_infomation ->isEmpty()  ){
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        //show the user uploads in the past in a nice format 
        // $user_infomation->itemuserimages()->where('user_id',$id)->get();
        return response()->json([
            'status' => 200,
            'ads' => $user_infomation,
       
        ], 200);

    }

    public  function  profileUserVideo($user_name){
          $user_videos =  HomeVideoResource::collection(ItemfreeVideosAds::where('user_name', $user_name)->get());
          if( $user_videos->isEmpty()){
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'videos'=>$user_videos
        ], 200);
    }

    public function Userprofile($user_name){
        // $user = User::where('id',$user_name)->get();
        $user_information = User::where('name',$user_name)->get();  /// change the id to name
        if($user_information->isEmpty()){
            return response()->json([
                'status' => 404,
                'message' => 'Sorry User does not exist '
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' =>$user_information
        ], 200);

    }



    public function profileEdit($iduser){
        // get users infomation 
        if (auth('sanctum')->check()) {
            $user_infomation = User::findOrFail($iduser);
            if ($user_infomation) {
                return response()->json([
                    'status' => 200,
                    'info' => $user_infomation
                ]);
            }
        }

    }

}











 // $user_auth =  Auth::user()->id;
                // $user_infomation->profileImage = $request->profi
                // $user_infomation->password
                // $user_infomation->id = $user_auth;
                    // return response()->json([
                    //     'status'=>200,
                    //     'updated' => $user_infomation
                    // ]);