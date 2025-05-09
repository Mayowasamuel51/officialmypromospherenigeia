<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomePageController;
use App\Http\Controllers\API\HomeTalkTweetUser;
use App\Http\Controllers\API\ItemfreeAdsController;
use App\Http\Controllers\API\ItemfreeVideosAdsController;
use App\Http\Controllers\API\ItemsAdsController;
use App\Http\Controllers\API\PromoTalkLikeController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\PromoTalk;
use App\Http\Controllers\PromoTweet;
use App\Http\Controllers\SellerVideoController;
use App\Http\Controllers\VerfieldController;
use Illuminate\Support\Facades\Route;


Route::get('test', function () {
    return 'hello ';
});

/// seller stories 
Route::get('/sellerstories', [ SellerVideoController::class, 'sellerstories']);
Route::get('/sellerstories/{id}', [ SellerVideoController::class, 'sellerstoriessingle']);

// testing fcm token 
Route::post('/store-token', [PromoTalkLikeController::class, 'storeToken']);
// Route::post('/send-notification/{user_id}',[PromoTalkLikeController::class,'sendNotification']);

// Route::post('/dislike', [PromoTalkLikeController::class, 'dislike']);

// ...........................    showing top sellers on the home page      NEW  ADS AND TALK ADS       ....................................
Route::get('/top-sellers',[HomeTalkTweetUser::class , 'topseller']);
Route::get('/top/{seller_name}',[HomeTalkTweetUser::class , 'personalSeller']);
Route::get('/laptops',[HomeTalkTweetUser::class , 'showcaselaptop']);


// verfieid 
Route::get('/verfieid', [VerfieldController::class, 'mainPeople']);


Route::get('auth', [AuthController::class, 'redirectToAuth']);
Route::get('auth/callback', [AuthController::class, 'handleAuthCallback']);
// -------- PROMOTALK ---------------------------

/// select talk
Route::get('/selecttalk/{categories}', [PromoTalk::class, 'selectingTalk']);

// view public promotalk
Route::get('/promotalks', [PromoTalk::class, 'promotalk']);
Route::get('/promotalks/{id}', [PromoTalk::class, 'promotalksingle']);
Route::get('/promotalksside', [PromoTalk::class, 'promotalksidebar']);
Route::get('/promotalksside/{id}', [PromoTalk::class, 'promotalksidebarsingle']);


//feedback api  for promotalk
Route::post('/promotalkfeedback/{itemid}', [PromoTalk::class, 'feedback']);
Route::get('/promotalkfeedback/{itemid}', [PromoTalk::class, 'getfeedback']);


// total talks
Route::get('/totaltalkscomment/{itemid}', [PromoTalk::class, 'totalcomment']);

// totals likes 
Route::get('/totaltalkslikes/{itemid}', [PromoTalkLikeController::class, 'totallikes']);
// -------- PROMOTALK ---------------------------


// -------- PROMOTWEET  ---------------------------

//lastest tweeet 
Route::get('/latesttweet', [PromoTweet::class, 'lastestTweet']);
Route::get('/latesttweet/{id}', [PromoTweet::class, 'lastestTweetsingle']);

/// select tweet 
Route::get('/selecttweet/{categories}', [PromoTweet::class, 'selectingTweet']);
// Route::get('/selecttweet/{id}', [PromoTweet::class, 'lastestTweetsingle']);


// view public promotalk
Route::get('/promotweet', [PromoTweet::class, 'promotweet']);
Route::get('/promotweet/{id}', [PromoTweet::class, 'promotweetsingle']);

// //feedback api  for promotalk dd
Route::post('/promotweetfeedback/{itemid}', [PromoTweet::class, 'feedback']);
Route::get('/promotweetfeedback/{itemid}', [PromoTweet::class, 'getfeedback']);



// -------- PROMOTWEET ---------------------------
// Public Api for login and Sighup 
Route::post('/login', [AuthController::class, 'login']);
Route::post('/sighup', [AuthController::class, 'sighup']);
Route::post('/logout', [AuthController::class, 'logout']);


// /// tesinng the uploading part 
// Route::post('/freeads', [ItemfreeAdsController::class, 'freeLimitedAds']);
// Route::post('/freeads/{id}/{type}', [ItemfreeAdsController::class, 'addimages']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/videotest', [SellerVideoController::class, 'videoupload']);


    Route::post('/send-notification/{user_id}',[PromoTalkLikeController::class,'sendNotification']);
    Route::post('/send-notification',[PromoTalkLikeController::class,'sendNot']);    

    // like talks 
    Route::delete('/dislike/{itemid}', [PromoTalkLikeController::class, 'dislike']);
    Route::post('/like/{itemid}', [PromoTalkLikeController::class, 'like']);
   


    // post for mypromotweet 
    Route::post('/promotweet', [PromoTweet::class, 'makepost']);     //Done
    Route::post('/promotweet/{id}', [PromoTweet::class, 'imagestweet']);

    // post for my promotalk
    Route::post('/promotalks', [PromoTalk::class, 'makepost']);
    Route::post('/promotalks/{id}', [PromoTalk::class, 'imagestalk']);



    // get User info route 
    Route::get('/getuser', [AuthController::class, 'getInfo']);
    //get user profile details 
    Route::get('/getuser/{id}', [UserController::class, 'settings']);

    // free  Ads Routes  
    // Route::post('/freeads', [ItemfreeAdsController::class, 'freeLimitedAds']);
    // Route::post('/freeads/{id}', [ItemfreeAdsController::class, 'addimages']);
    Route::post('/vidoesfreeads', [ItemfreeVideosAdsController::class, 'freeLimitedAds']);


    //update user information from setting page .............................................
    Route::put('/user/settings/{iduser}', [UserController::class, 'updateuserinfo']);
    Route::put('/user/settings/background/{iduser}', [UserController::class, 'updatebackgroundimage']);
    Route::get('/user/info/{iduser}', [UserController::class, 'profileEdit']);



    // PersonalUploads for a user
    Route::get('/posts/{id}', [UserController::class, 'personalUploads']);
    Route::get('/postsvideos/{id}', [UserController::class, 'personalVideos']);


    // Paid Ads 
    Route::post('/normalads', [ItemsAdsController::class, 'ItemsAdsStore']);


    /// tesinng the uploading part 
    Route::post('/freeads', [ItemfreeAdsController::class, 'freeLimitedAds']);
    Route::post('/freeads/{id}/{type}', [ItemfreeAdsController::class, 'addimages']);
});


// Homepage search side 
Route::get('/search/{query}', [HomePageController::class, 'searchapi']);

//  Trending Ads Api 
Route::get('/trendingads', [HomePageController::class, 'generalTrending']);
Route::get('/trendingads/{id}', [HomePageController::class, 'generalTrendingPage']);


// Top level  Product and Service MVP ...............................
Route::get('/topads/{categories}', [HomePageController::class, 'toplevelads']);
// Route::get('/toplevel/{id}', [HomePageController::class, 'toplevelads']);


//Discount Link 
Route::get('/discount', [HomePageController::class, 'Discount']);
// Route::get('/discount/{id}', [HomePageController::class, 'Discount']);

// baby Link
Route::get('/Kids_Baby_dresses', [HomePageController::class, 'baby']);
// Route::get('/Kids_Baby_dresses',[HomePageController::class , 'baby']);

//property Api 
Route::get('/property', [HomePageController::class, 'Property']);
// Route::get('/Kids_Baby_dresses',[HomePageController::class , 'baby']);

// Luxury-apartment api 
Route::get('/luxuryapartment', [HomePageController::class, 'Luxury_apartment']);

Route::get('/Vehicles_Upgrade', [HomePageController::class, 'Vehicles_Upgrade']);

//Laptops data api 
// Route::get('/laptops', [HomePageController::class, 'Laptops']);

//Cars data api 
Route::get('/cars', [HomePageController::class, 'Cars']);

// Top videoes Ads 
Route::get('/trendingadsvideos', [HomePageController::class, 'generalTopVideos']);
Route::get('/trendingadsvideos/{id}', [HomePageController::class, 'generalTopVideosPage']);


// User click  profile Api   ..see other this be the users
Route::get('/userpostsuploads/{user_name}', [UserController::class, 'profileUserPost']);
Route::get('/uservideosuploads/{user_name}', [UserController::class, 'profileUserVideo']);
Route::get('/profile/{user_name}', [UserController::class, 'Userprofile']);


//feedback api 
Route::post('/feedback/{itemid}', [FeedBackController::class, 'feedback']);
Route::get('/feedback/{itemid}', [FeedBackController::class, 'getfeedback']);









//   Home-page Public  api and other  public   apis for other pages 
// 1)  Seaarch engine powerfull api ( auto generated word )

// 2) Categiories Api  
Route::get('/categoriesapi', [HomePageController::class, 'categoriesapi']);
Route::get(
    '/categoriesapi/{categoriesapi}/{state}/{local_gov}',
    [HomePageController::class, 'categoriesapiSinglePages']
);
// 3) Personlized Ads Api 



























// 6) Top  Services Api 

// Trending Ads api with Headlines  ( method is hard coded  on the frist time user goes to the site   )
/// 1 ) headlinesApartment
Route::get('/apartment/{state}', [HomePageController::class, 'headlinesApartment']);
// 2) headlinesPhones, Tablets
Route::get('/phones/{state}', [HomePageController::class, 'headlinephones']);
// 3) headlines for Baby products 

// 4) headlines for Fashions 

/// 5 ) headlines for Cars
Route::get('/cars/{state}', [HomePageController::class, 'headlinecars']);

/// 6 ) headlines for Grocerys 

// 7 ) headlines for Health and Beauty 

///test endpoint
Route::get('/test', [ItemfreeAdsController::class, 'showoneimage']);




















// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });  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