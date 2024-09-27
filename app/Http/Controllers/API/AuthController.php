<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use App\Traits\HttpResponse;
use GuzzleHttp\Exception\ClientException;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    //
    //  public function __construct(){
    //     $this->middleware('auth:sanctum')
    //     ->except(['sighup','login']);
    // }
    use HttpResponse;
    public function redirectToAuth(): JsonResponse
    {
        return response()->json([
            'url' => Socialite::driver('google')
                ->stateless()
                ->redirect()
                ->getTargetUrl(),
        ]);
    }
    public function handleAuthCallback(): JsonResponse
    {
        try {
            /** @var SocialiteUser $socialiteUser */
            $socialiteUser = Socialite::driver('google')->stateless()->user();
        } catch (ClientException $e) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        /** @var User $user */
        $user = User::query()
        ->firstOrCreate(
        // $user =  User::updateOrCreate(
            [
                'email' => $socialiteUser->getEmail(),
            ],
            [
                'email_verified_at' => now(),
                'name' => $socialiteUser->getName(),
                'user_social'=>$socialiteUser->user_social,
                'google_id' =>$socialiteUser->getId(),
                'avatar' => $socialiteUser->getAvatar(),
                'current_plan' => "free_plan",
                'id_number' => rand(1222, 45543),
                'password' => $socialiteUser->password,
            ]
        );
        // Auth::login($user);
        $token = $user->createToken('google-token' . $user->name)->plainTextToken;
        return response()->json([
            'token' => $token,
            'user_social'=>$user->user_social,
            'profileImage' => $user->profileImage,
            'user' => $user->email,
            'user_name' => $user->name,
            'id' => $user->id,
            'users' => $user,
            // 'token' => $user->createToken('google-token'.$user->name)->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }





    public function  getInfo()
    {
        // get user info base on token to show for 
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'You are not unauthenticated Procced to login or register '
            ]);
        }
        $info = User::where('id', $user->id)->get();
        if (!$info) {
            return response()->json([
                'status' => 401,
                'message' => 'You are not unauthenticated Procced to login or register '
            ]);
        }
        return response()->json([
            'status' => 20,
            'data' => $info
        ]);
    }
    public function sighup(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            throw ValidationException::withMessages([
                'email' => ['Email Exist already procced to login']
            ], 401);
        } else {
            $createuser  =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'current_plan' => "free_plan",
                'id_number' => rand(1222, 45543),
                'password' => Hash::make($request->password)
            ]);
            $token = $createuser->createToken("API-TOKEN" . $createuser->email)->plainTextToken;
            return response()->json([
                'token' => $token,
                'status' => 201,
                'success' => $createuser
            ]);
        }
    }


    public function login(Request $request)
    {
        /// this is not working well .still need to fix need to checking of passwords
        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'required'
        // ]);
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['email or password is not correct']
            ], 401);
        } else {
            // if (!$user ||  !Hash::check($request->password, $user->password)) {
            //     return response()->json([
            //         'status' => 422,
            //         'dum'=>$user->email ,
            //         'pass'=> $user->password,
            //         'message' => 'invaild credentials'
            //     ]);
            // }
            //  else {
            $token =  $user->createToken("API-TOKEN" . $user->email)->plainTextToken;
            return response()->json([
                'status' => 200,
                'user_social'=>$user->user_social,
                'token' => $token,
                'aboutMe'=>$user->aboutMe,
                'whatapp'=>$user->whatapp,
                'profileImage' => $user->profileImage,
                'backgroundimage' => $user->backgroundimage,
                'user' => $user->email,
                'user_phone' => $user->user_phone,
                'websiteName' => $user->websiteName,
                'user_name' => $user->name,
                'brandName' => $user->brandName,
                'id' => $user->id
            ]);
        }
    }

    public function logout(Request $request)
    {
        /** @var User $user */
        $request->user()->tokens()->delete();
        return  response()->json([
            'status' => 200,
            'message' => 'u have logout '
        ]);
    }
}

        // if(!Auth::attempt($request->only(['email'=>$request->email ,'password'=>Hash::check($request->password, $user->password)]))){
        //     return  response()->json([ 
        //     "inviad users or worng password"=> 422]);
        // }
        // $user = User::where('email', $request->email)->first(); // 
        // if(!$user  && Hash::check($request->password, $user->password)){
        //     throw ValidationException::withMessages([
        //         'email'=>['email not correct']
        //     ], 401);
        // }

        // if(Hash::check($request->password, $user->password)){
        //     throw ValidationException::withMessages([
        //         'email'=>['email not correct or password']
        //     ], 422);
        // }