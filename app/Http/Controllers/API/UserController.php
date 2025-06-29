<?php

namespace App\Http\Controllers\API;

use App\Models\Externalinfo;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\HomePageControllerResource;
use App\Http\Resources\HomeVideoResource;
use App\Models\ItemfreeAds;
use App\Models\ItemfreeVideosAds;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserController extends Controller

{

    public function downloadPdfSlide(Request $request, $id, $pdfinfo)
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized User!!!',
            ], 401);
        }
        // Find the user by ID extra proctecton 
        $user = User::findOrFail($id);
        if ($user) {
            // now you send the pdf to the server 
            $items = new  Externalinfo;
            $image_one = $request->titleImageurl;
            if ($image_one) {
                $manager = new ImageManager(new Driver());
                $image_one_name = hexdec(uniqid()) . '.' . strtolower($image_one->getClientOriginalExtension());
                $image = $manager->read($image_one);
                $final_image = 'pdf/files/' . $image_one_name;
                $image->save($final_image);
                $photoSave1 = $final_image;
                $rro = 1;
            }
            // $items->titleImageurl =  $photoSave1;
            // return response()->json([
            //     'status' => 200,
            //     'data' => $user,
            // ]);
        }
        // If user is not found
        return response()->json([
            'status' => 404,
            'message' => 'User not found',
        ], 404);
    }

    public function checkinguser($id)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 401, 'message' => 'Unauthorized']);   // the pentester will bypass this becos he is registered on the application 
        }

        $user = User::find($id); // the pentester will be able to switch from his id to another user id becos of this code here 
        return response()->json(['status' => 200, 'data' => $user]);

        if (auth('sanctum')->check()) {
            $user  = User::find($id);
            if ($user) {
                return response()->json([
                    'status' => 200,
                    'data' => $user
                ]);
            }
        }
    }


    // public function checkinguser($id)
    // {
    //     if (!auth('sanctum')->check()) {
    //         return response()->json(['status' => 401, 'message' => 'Unauthorized'], 401);
    //     }

    //     $authUser = auth('sanctum')->user();

    //     // Prevent IDOR: Only allow users to access their own data
    //     if ($authUser->id != $id) {
    //         return response()->json(['status' => 403, 'message' => 'Forbidden you cant view this '], 403);
    //     }

    //     return response()->json(['status' => 200, 'data' => $authUser]);
    // }


    public function gettinguserprofile($user_name)
    {
        $user = User::where('name', $user_name)->get();
        if ($user) {
            return response()->json([
                'status' => 200,
                'data' => $user,
            ]);
        }
        // If user is not found

        return response()->json([
            'status' => 404,
            'message' => 'User not found',
        ], 404);
    }


    public function mainupdate(Request $request, $id)
    {
        if (auth('sanctum')->check()) {
            $user = User::findOrFail($id);
            if (!$user) {
                return response()->json(['status' => 404, 'message' => 'User not found']);
            }

            // Only update fields that are present in the request
            if ($request->filled('UserName')) {
                $user->name = $request->UserName;
            }
            if ($request->filled('websiteName')) {
                $user->websiteName = $request->websiteName;
            }
            if ($request->filled('messageCompany')) {
                $user->messageCompany = $request->messageCompany;
            }
            if ($request->filled('aboutMe')) {
                $user->aboutMe = $request->aboutMe;
            }
            if ($request->filled('brandName')) {
                $user->brandName = $request->brandName;
            }
            if ($request->filled('whatapp')) {
                $user->whatapp = $request->whatapp;
            }
            if ($request->filled('user_phone')) {
                $user->user_phone = $request->user_phone;
            }
            if ($request->filled('user_social')) {
                $user->user_social = $request->user_social;
            }


            // if ($request->hasFile('backgroundimage')) {
            //     // 🧹 Delete old background image if it exists
            //     if ($user->backgroundimage && File::exists(public_path($user->backgroundimage))) {
            //         File::delete(public_path( 'profile/images/' .$user->backgroundimage));
            //     }

            //     $backgroundImage = $request->file('backgroundimage');
            //     $manager = new ImageManager(new Driver());
            //     $filename = hexdec(uniqid()) . '.' . strtolower($backgroundImage->getClientOriginalExtension());
            //     $image = $manager->read($backgroundImage);
            //     $finalPath = 'profile/images/' . $filename;
            //     $image->save(public_path($finalPath));
            //     $user->backgroundimage = $finalPath; // ✅ Save new path
            // }

            // if ($request->hasFile('profileImage')) {
            //     // 🧹 Delete old profile image if it exists
            //     if ($user->profileImage && File::exists(public_path($user->profileImage))) {
            //         File::delete(public_path( 'profile/images/' .$user->profileImage));
            //     }

            //     $profileImage = $request->file('profileImage');
            //     $manager = new ImageManager(new Driver());
            //     $filename = hexdec(uniqid()) . '.' . strtolower($profileImage->getClientOriginalExtension());
            //     $image = $manager->read($profileImage);
            //     $finalPath = 'profile/images/' . $filename;
            //     $image->save(public_path($finalPath));
            //     $user->profileImage = $finalPath; // ✅ Save new path
            // }
            //    $user_infomation->backgroundimage = $request->backgroundimage;
            $image_backimage = $request->backgroundimage;
            // $image_backimage = $request->backgroundimage;
            if ($image_backimage) {
                if ($image_backimage) {
                    $manager = new ImageManager(new Driver());
                    $image_backimage_name = hexdec(uniqid()) . '.' . strtolower($image_backimage->getClientOriginalExtension());
                    $image = $manager->read($image_backimage);
                    $final_image = 'profile/images/' . $image_backimage_name;
                    $image->save($final_image);
                    $photoSave1 = $final_image;
                    $user->backgroundimage =  $photoSave1;
                }
            }
            $image_one = $request->profileImage;
            // If you later want to allow profileImage again:
            // $image_one = $request->profileImage;
            if ($image_one) {

                if ($image_one) {
                    $manager = new ImageManager(new Driver());
                    $image_one_name = hexdec(uniqid()) . '.' . strtolower($image_one->getClientOriginalExtension());
                    $image = $manager->read($image_one);
                    $final_image = 'profile/images/' . $image_one_name;
                    $image->save($final_image);
                    $photoSave1 = $final_image;
                    $user->profileImage =  $photoSave1;
                }
            }

            $user->update();

            return response()->json([
                'status' => 200,
                'updated' => $user
            ]);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Unauthorized'
        ]);
    }
    public function personalUploads($id)
    {
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
            if ($userUploadsPost->isEmpty()) {
                return response()->json([
                    'status' => 404,
                    'message' => 'No orders found matching the query.'
                ], 404);
            }
            return response()->json([
                'status' => 200,
                'posts' => $userUploadsPost,

            ]);
        }
    }

    public function personalVideos($id)
    {
        $userUploadsVideo =  User::find($id)->itemuserivideo()->where('user_id', $id)->latest()->get();
        if ($userUploadsVideo->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        return response()->json([
            'status' => 200,

            'posts' => $userUploadsVideo
        ]);
    }
    public function updateuserinfo(Request $request, $iduser)
    {
        $validator = Validator::make($request->all(), [
            // 'profileImage' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {

            if (auth('sanctum')->check()) {
                $user_infomation = User::find($iduser);
                if ($user_infomation) {

                    $user_infomation->user_name = $request->UserName;

                    $user_infomation->websiteName = $request->websiteName;

                    $user_infomation->messageCompany = $request->messageCompany;

                    $user_infomation->aboutMe = $request->aboutMe;
                    $user_infomation->brandName = $request->brandName;

                    $user_infomation->whatapp = $request->whatapp;

                    $user_infomation->user_phone = $request->user_phone;

                    $user_infomation->user_social = $request->user_social;

                    $image_one = $request->profileImage;
                    if ($image_one) {

                        $manager = new ImageManager(new Driver());
                        $image_one_name = hexdec(uniqid()) . '.' . strtolower($image_one->getClientOriginalExtension());

                        $image = $manager->read($image_one);

                        $final_image = 'profile/images/' . $image_one_name;

                        $image->save($final_image);

                        $photoSave1 = $final_image;

                        $user_infomation->profileImage =  $photoSave1;
                    }
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

    public function updatebackgroundimage(Request $request, $iduser)
    {
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


    public function profileUserPost($id)
    {
        // $user = User::where('id',$id)->get();  .i chnage the user_id to user_name 
        $user_infomation = HomePageControllerResource::collection(ItemfreeAds::where('user_name', $id)->get());
        if ($user_infomation->isEmpty()) {
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

    public  function  profileUserVideo($user_name)
    {
        $user_videos =  HomeVideoResource::collection(ItemfreeVideosAds::where('user_name', $user_name)->get());
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

    public function Userprofile($user_name)
    {
        //  $user_information = User::where('name', $user_name)->get(); 
        // $user = User::where('id',$user_name)->get();
        $user_information = User::where('name', $user_name)->get();  /// change the id to name
        if ($user_information->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Sorry User does not exist '
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $user_information
        ], 200);
    }



    public function profileEdit($iduser)
    {
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


// / public function gettinguserprofile($user_name)
    // {
    //     $authUser = auth('sanctum')->user();

    //     if (!$authUser) {
    //         return response()->json([
    //             'status' => 401,
    //             'message' => 'Unauthorized',
    //         ], 401);
    //     }

    //     // Check if the username being requested matches the logged-in user's name
    //     if ($authUser->name !== $user_name) {
    //         return response()->json([
    //             'status' => 403,
    //             'message' => 'Forbidden - You can only view your own profile.',
    //         ], 403);
    //     }

    //     // Get the user (should be only one)
    //     $user = User::where('name', $user_name)->first();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => 404,
    //             'message' => 'User not found',
    //         ], 404);
    //     }

    //     return response()->json([
    //         'status' => 200,
    //         'data' => $user,
    //     ]);
    // }


    // public function checkinguser($id)
    // {
    //     // Check if the user is authenticated via Sanctum
    //     if (!auth('sanctum')->check()) {    // if the attacker is authenticated , which he is  everyone that has account..
    //         return response()->json([
    //             'status' => 401,
    //             'message' => 'Unauthorized',
    //         ], 401);  /// passed 

    //         // 3  34
    //     }
    //     // Find the user by ID
    //     $user = User::findOrFail($id);  // this code is bad , becos the attacker can switch from his id to another authenticed user if 
    //     if ($user) {
    //         return response()->json([
    //             'status' => 200,
    //             'data' => $user,
    //         ]);
    //     }
    //     // If user is not found
    //     return response()->json([
    //         'status' => 404,
    //         'message' => 'User not found',
    //     ], 404);
    // }


// public function mainupdate(Request $request, $id)
    // {
    //     if (auth('sanctum')->check()) {
    //         $user = User::find($id);
    //         if (!$user) {
    //             return response()->json(['status' => 404, 'message' => 'User not found']);
    //         }

    //         // Update only fields that are present
    //         if ($request->UserName) {
    //             $user->name = $request->UserName;
    //         }
    //         if ($request->websiteName) {
    //             $user->websiteName = $request->websiteName;
    //         }
    //         if ($request->messageCompany) {
    //             $user->messageCompany = $request->messageCompany;
    //         }
    //         if ($request->aboutMe) {
    //             $user->aboutMe = $request->aboutMe;
    //         }
    //         if ($request->brandName) {
    //             $user->brandName = $request->brandName;
    //         }
    //         if ($request->whatapp) {
    //             $user->whatapp = $request->whatapp;
    //         }
    //         if ($request->user_phone) {
    //             $user->user_phone = $request->user_phone;
    //         }
    //         if ($request->user_social) {
    //             $user->user_social = $request->user_social;
    //         }

    //         $manager = new ImageManager(new Driver());

    //         // Save profile image
    //         // if ($request->hasFile('profileImage')) {
    //         //     $profileImage = $request->file('profileImage');
    //         //     $imageName = hexdec(uniqid()) . '.' . strtolower($profileImage->getClientOriginalExtension());
    //         //     $image = $manager->read($profileImage);
    //         //     $finalImagePath = 'profile/images/' . $imageName;
    //         //     $image->save($finalImagePath);
    //         //     $user->profileImage = $finalImagePath;
    //         // }

    //         // // Save background image
    //         // if ($request->hasFile('backgroundimage')) {
    //         //     $backgroundImage = $request->file('backgroundimage');
    //         //     $imageName = hexdec(uniqid()) . '.' . strtolower($backgroundImage->getClientOriginalExtension());
    //         //     $image = $manager->read($backgroundImage);
    //         //     $finalImagePath = 'profile/images/' . $imageName;
    //         //     $image->save($finalImagePath);
    //         //     $user->backgroundimage = $finalImagePath;
    //         // }

    //         $user->update();

    //         return response()->json([
    //             'status' => 200,
    //             'updated' => $user
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => 401,
    //         'message' => 'Unauthorized'
    //     ]);
    // }


// 488|WLrteLs24Bwm3BkHNvbQSguXSz8Xr1MwzLAPDdpef75d6994





 // $user_auth =  Auth::user()->id;
                // $user_infomation->profileImage = $request->profi
                // $user_infomation->password
                // $user_infomation->id = $user_auth;
                    // return response()->json([
                    //     'status'=>200,
                    //     'updated' => $user_infomation
                    // ]);