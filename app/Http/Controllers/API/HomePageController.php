<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdsImagesResource;
use App\Http\Resources\HomePageControllerResource;
use App\Http\Resources\HomePageResource;
use App\Http\Resources\HomeVideoResource;
use App\Models\AdsImages;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\categories;
use App\Models\ItemfreeAds;
use App\Models\ItemfreeVideosAds;

class HomePageController extends Controller
{

    // public  function __construct()
    // {
    //     $this->middleware('throttle:120,1')->only([
    //         'generalTrending'
    //     ]);
    // }


    public function searchapi($query) {
        $orders = HomePageControllerResource::collection(ItemfreeAds::with('user')
            ->where('categories', 'LIKE', '%' . $query . '%')
            ->orWhere('productName', 'LIKE', '%' . $query . '%')
            ->get());
        if ($orders->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $orders
        ]);
    }
    public function categoriesapi()
    {
        // display all categories api in database and make query to one when they click one 
        $categories = \App\Http\Resources\categoriesResource::collection(categories::all());
        if ($categories) {
            return response()->json([
                'status' => 200,
                'message' => $categories
            ]);
        }
        return response()->json([
            'status' => 500,
            'message' => "Network Problem!!"
        ]);
    }

    public function headlinesApartment($state)
    {
        //  Headlines for apartment , limit the result  
        // we need to change this all the time , for paid users, benefits 
        $fetch_images =   HomePageControllerResource::collection(DB::table('itemfree_ads')
            ->where('itemfree_ads.categories', 'Apartment')
            ->where('itemfree_ads.state', $state)
            // ->join('itemfree_videos_ads', 'itemfree_ads.state', '=', 'itemfree_videos_ads.state')
            ->inRandomOrder()
            ->get());
        $test = AdsImages::where('itemfree_ads_id', 2)->first();;

        $fetch_videos = HomePageResource::collection(DB::table('itemfree_videos_ads')
            ->where('itemfree_videos_ads.categories', 'Apartment')
            ->where('itemfree_videos_ads.state', $state)->inRandomOrder()
            ->get());;

        // check if the person does not allow their location to be turned on 


        return response()->json([
            'status' => 200,
            'test' => $test,
            'normalads' => $fetch_images,
            'videos' => $fetch_videos
        ]);
    }
    public function headlinephones($state)
    {
        $fetch_images =   HomePageControllerResource::collection(DB::table('itemfree_ads')
            ->where('itemfree_ads.categories', 'Phones, Tablets')
            ->where('itemfree_ads.state', $state)
            // ->join('itemfree_videos_ads', 'itemfree_ads.state', '=', 'itemfree_videos_ads.state')
            ->inRandomOrder()
            ->get());

        $fetch_videos = HomePageResource::collection(DB::table('itemfree_videos_ads')
            ->where('itemfree_videos_ads.categories', 'Phones, Tablets')
            ->where('itemfree_videos_ads.state', $state)->inRandomOrder()
            ->get());;


        return response()->json([
            'status' => 200,
            'normalads' => $fetch_images,
            'videos' => $fetch_videos
        ]);
    }


    public function headlinecars($state)
    {
        $fetch_images =   HomePageControllerResource::collection(DB::table('itemfree_ads')
            ->where('itemfree_ads.categories', 'Automotive , Vehicles')
            ->where('itemfree_ads.state', $state)
            // ->join('itemfree_videos_ads', 'itemfree_ads.state', '=', 'itemfree_videos_ads.state')
            ->inRandomOrder()
            ->get());

        $fetch_videos = HomePageResource::collection(DB::table('itemfree_videos_ads')
            ->where('itemfree_videos_ads.categories', 'Automotive , Vehicles')
            ->where('itemfree_videos_ads.state', $state)->inRandomOrder()
            ->get());;

        // do a error handing on them 
        return response()->json([
            'status' => 200,
            'normalads' => $fetch_images,
            'videos' => $fetch_videos
        ]);
    }


    public function categoriesapiSinglePages($categories, $state, $local_gov, Request $request)
    {
        $database_table_one = ItemfreeAds::where('categories', $categories)
            ->where('state', $state)->where('local_gov', $local_gov)->get();
        // what if the user did not allow to access location  or  third party cookies   what do we do 
        // we need to ask user for thire location to get better result for them 

        // Build a function to show ads base on user location  
        // Use recommendation Algortim  .... show people who as paid compared to people using freeplan 
        // Table to be used === 
        // Itemfree table , Itemvideo table , Service providers table , Itemtable , Itemvideo table 
        // IP geolocation vs. user-provided location vs. browsing behavior  vs user not proving there location 
        // headlines Api   ..........................................
        // also work with the plan ==== Basic Benefit , Standard Benefit , Premium   Benefit 
        // also add eager loading!!!!!! important one
        // Alos be to make to get popluar in a state when they load site
        $homepagerender_state = DB::table('itemfree_ads')
            ->join(
                'itemfree_videos_ads',
                'itemfree_ads.state',
                '=',
                'itemfree_videos_ads.state'
            )
            ->where('itemfree_ads.state', $state)
            ->where('itemfree_ads.categories', $categories)
            ->inRandomOrder()
            ->get();

        $homepagerender_local_gov = DB::table('itemfree_ads')
            ->join(
                'itemfree_videos_ads',
                'itemfree_ads.local_gov',
                '=',
                'itemfree_videos_ads.local_gov'
            )
            ->where('itemfree_ads.categories', $categories)
            ->where('itemfree_ads.local_gov', $local_gov)
            ->inRandomOrder()->get();

        // $homepage_general
        //General headline api  
        $headline_categories_ =  DB::table('itemfree_ads')
            ->join('itemfree_videos_ads', 'itemfree_ads.state',  '=', 'itemfree_videos_ads.state')
            ->where('itemfree_ads.headlines', 'Get best women wares')
            ->where('itemfree_ads.state', $state)
            ->where('itemfree_ads.categories', $categories)

            // ->inRandomOrder()
            ->get();

        if ($state === "" || $local_gov  === "") {
            return response()->json([
                'message' => 'not workign well '
            ]);
        }
        if ($homepagerender_state) {
            return response()->json([
                'status' => 200,
                'message' => $headline_categories_,
                // 'local_gov' => $homepagerender_local_gov
            ]);
        }
    }




    public function generalTrending()
    {
        // this function will produce all ads base on location of the user or other wise , which will just be videos alone 
        /// note will be changing it to images sometimes 

        // $categories = [
        //     "shortlet",

        //     "Laptops",

        //     "Property",

        //     "Phones, Tablets",

        //     "Fragrances",

        //     "Skincare",

        //     "Groceries",

        //     "home-decoration",

        //     "Furniture ,Home ",

        //     "Womens bikins",

        //     "Kids , Baby dresses",

        //     "Womens under waress",

        //     "womens-dresses",

        //     "womens-shoes",

        //     "Pets",

        //     "Mens-shirts",

        //     "Mens-shoes",

        //     "Mens-watches",

        //     "Womens-watches",

        //     "Womens-bags",

        //     "Womens-jewellery",

        //     "Vehicles Upgrade",

        //     "Automotive , Vehicles",

        //     "Motorcycle",

        //     "Apartment",

        //     "Fashion",  /// on we put Fashion

        //     "Sport Dresses",


        //     "Luxury-apartment"
        // ];
        $categories = [
            "Shortlets & Rentals", // updated for clarity
            "Laptops & Accessories",
            "Real Estate",
            "Phones & Tablets",
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
        

        // $state = ['Lagos']
        // will be changing the table manuelly for now , and include the paid user table to it soon 
        $fetch_images = HomePageControllerResource::collection(
            DB::table('itemfree_ads')
                ->whereIn('itemfree_ads.categories', $categories)
                ->latest()
                // ->inRandomOrder()
                // ->paginate(8)
                ->limit(50)
                ->get()
        );

        $fetch_details  =  DB::table('ads_images')->join('itemfree_ads', function (JoinClause $join) {
            $join->on('ads_images.itemfree_ads_id', '=', 'itemfree_ads.id');
        })
            ->inRandomOrder()
            ->get();
        $adimages_data = AdsImagesResource::collection(AdsImages::all());

        if ($fetch_images) {
            return response()->json([
                'status' => 200,
                'normalads'  =>  $fetch_images,
                'other_images' => $adimages_data
                // $fetch_details
            ]);
        }
        return response()->json([
            'status' => 500,
            'messages' => 'something went worng',
            // 'local_gov' => $homepagerender_local_gov
        ]);
    }


    public function generalTrendingPage($id)
    {
        // join the itemfreead and adimages , so when user clicks on one post it show remaining information of that post 
        /// we neeed to cahce this  funciton becos of lot of Load
        $fetch_details  = ItemfreeAds::find($id);
        $fetch_details->adsimages()->where('itemfree_ads_id', $id)->get();
        $fetch_details_others  =  ItemfreeAds::find($id)->adsimages()->where('itemfree_ads_id', $id)->inRandomOrder()->get();
        if ($fetch_details) {
            return response()->json([
                'status' => 200,
                'data' => $fetch_details,
                'other_data' => $fetch_details_others
            ]);
        }
        // if ($fetch_details->isEmpty()   || $fetch_details_others->isEmpty()  ) {
        return response()->json([
            'status' => 404,
            'message' => 'No orders found matching the query.'
        ], 404);
        // }

    }

    public function generalTopVideos()
    {
        $categories = [
            "Laptops",

            "Property",

            "Phones, Tablets",

            "Fragrances",

            "Skincare",

            "Groceries",

            "home-decoration",

            "Furniture ,Home ",

            "Womens bikins",

            "Kids , Baby dresses",

            "Womens under waress",

            "womens-dresses",

            "womens-shoes",

            "Pets",

            "Mens-shirts",

            "Mens-shoes",

            "Mens-watches",

            "Womens-watches",

            "Womens-bags",

            "Womens-jewellery",

            "Vehicles Upgrade",

            "Automotive , Vehicles",

            "Motorcycle",

            "Apartment",

            "Fashion",  /// on we put Fashion

            "Sport Dresses",


            "Luxury-apartment"
        ];
        $fetch_top_videos = HomeVideoResource::collection(
            DB::table('itemfree_videos_ads')
                ->whereIn('itemfree_videos_ads.categories', $categories)
                ->inRandomOrder()
                ->get()
        );
        if ($fetch_top_videos) {
            return response()->json([
                'status' => 200,
                'videos'  =>  $fetch_top_videos
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'No orders found matching the query.'
        ], 404);
        // return response()->json([
        //     'status' => 200,
        //     'videos'  =>  $fetch_top_videos
        // ]);
    }

    public function generalTopVideosPage($id)
    {
        $fetch_details  =  HomeVideoResource::collection(ItemfreeVideosAds::where('id', $id)->get());
        if ($fetch_details->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $fetch_details,
        ]);
    }

    public function toplevelads($categories)
    {
        //  This top level function will be for showing different categories that hasnt showing in the trending part ............
        //  Also we be changing to video part some times  ...........................
        //  Also this will be showing dicount price ....................
        $fetch_images = HomePageControllerResource::collection(
            DB::table('itemfree_ads')
                ->where('itemfree_ads.categories', $categories)
                ->inRandomOrder()
                // ->paginate(8)
                ->limit(1000)
                ->get()
        );
        $adimages_data = AdsImagesResource::collection(AdsImages::all());
        if ($fetch_images) {
            return response()->json([
                'status' => 200,
                'normalads'  =>  $fetch_images,
                'other_images' => $adimages_data

            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'No orders found matching the query.'
        ], 404);
    }

    public function  Discount()
    {
        // this is discount option will be a navbar option on the home-page
        $categories = [
            "Laptops",

            "Property",

            "Phones, Tablets",

            "Fragrances",

            "Skincare",

            "Groceries",

            "home-decoration",

            "Furniture ,Home ",

            "Womens bikins",

            "Kids , Baby dresses",

            "Womens under waress",

            "womens-dresses",

            "womens-shoes",

            "Pets",

            "Mens-shirts",

            "Mens-shoes",

            "Mens-watches",

            "Womens-watches",

            "Womens-bags",

            "Womens-jewellery",

            "Vehicles Upgrade",

            "Automotive , Vehicles",

            "Motorcycle",

            "Apartment",

            "Fashion",  /// on we put Fashion

            "Sport Dresses",


            "Luxury-apartment"
        ];
        $discount_options = DB::table('itemfree_ads')
            ->where('discount', 'Yes')
            ->orWhere('itemfree_ads.categories', $categories)
            ->inRandomOrder()
            ->limit(50)
            ->get();
        $adimages_data = AdsImagesResource::collection(AdsImages::all());
        if ($discount_options->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'discount' => $discount_options,
            'other_image' => $adimages_data
        ]);
    }

    public function  baby()
    {
        $Kids_Baby_dresses = DB::table('itemfree_ads')
            ->where('discount', 'yes')
            ->where('itemfree_ads.categories', 'Kids , Baby dresses')
            ->inRandomOrder()
            ->limit(40)->get();
        if ($Kids_Baby_dresses->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'Kids_Baby_dresses' =>  $Kids_Baby_dresses
        ]);
    }

    public function  Property()
    {
        $Property = DB::table('itemfree_ads')
            // ->where('discount','yes')
            ->where('itemfree_ads.categories', 'Property')
            ->inRandomOrder()
            ->limit(40)->get();
        if ($Property->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'property' =>  $Property
        ]);
    }

    // Luxury-apartment

    public function Luxury_apartment()
    {
        $Luxury_apartments = DB::table('itemfree_ads')
            // ->where('discount','yes')
            ->where('itemfree_ads.categories', 'Luxury-apartment')
            ->inRandomOrder()
            ->limit(40)->get();
        if ($Luxury_apartments->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'Luxury-apartment' =>   $Luxury_apartments
        ]);
    }


    public function Vehicles_Upgrade()
    {
        $Vehicles_Upgrade = DB::table('itemfree_ads')
            // ->where('discount','yes')
            ->where('itemfree_ads.categories', 'Vehicles Upgrade')
            ->inRandomOrder()
            ->limit(40)->get();
        if ($Vehicles_Upgrade->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'Vehicles-Upgrade' =>   $Vehicles_Upgrade
        ]);
    }

    public function Laptops()
    {
        $laptopsdata = DB::table('itemfree_ads')
            // ->where('discount','yes')
            ->where('itemfree_ads.categories', 'Laptops')
            ->inRandomOrder()
            ->limit(20)->get();
        if ($laptopsdata->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' =>   $laptopsdata
        ]);
    }

    public function Cars()
    {
        $cardata = DB::table('itemfree_ads')
            // ->where('discount','yes')
            ->where('itemfree_ads.categories', 'Automotive , Vehicles')
            ->inRandomOrder()
            ->limit(20)->get();
        if ($cardata->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No orders found matching the query.'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' =>   $cardata
        ]);
    }

    public function trendingads() {}
}




   // $fetch_details  = ItemfreeAds::all();
        // $fetch_details->adsimages()->where('itemfree_ads_id',$fetch_details->id )->get();
        // $fetch_details_others  = 
        // ItemfreeAds::find($id)->adsimages()->where('itemfree_ads_id', $id)->inRandomOrder()->get();
       

// note the categoriesapi will return a response , it the repsonse we are gonna use  in this categoriesapiSinglePage   !!!!!
        // listing all  service or trending under each categories clicked upon 
        // combine trending Ads +  Service  Ads ===== +  
        // Table to be used === 
        // Itemfree table , Itemvideo table , Service providers table , Ttem table , Itemvideo table 
        // Use recommendation Algortim  .... show people who as paid compared to people using freeplan 
        //also fetch base on headlines ----- this is important   most of them used they same headlines 
        // also fetch base on location of the person seraching for something  this is very important becos of privacy iisues
        // crucial to prioritize user privacy and ensure accurate results.
        // include random result fetch from the databse 



        // DB::table('users')
        // ->join('contacts', 'users.id', '=', 'contacts.user_id')
        // ->join('orders', 'users.id', '=', 'orders.user_id')
        // ->select('users.*', 'contacts.phone', 'orders.price')
        // ->get();


















        // $categories = [
        //     "Laptops",
        //     "Property",
        //     "Phones, Tablets",
        //     "Fragrances",
        //     "Skincare",
        //     "Groceries",
        //     "home-decoration",
        //     "Furniture ,Home ",
        //     "Womens bikins",
        //     "Kids , Baby dresses",
        //     "Womens under waress",
        //     "womens-dresses",
        //     "womens-shoes",
        //     "Pets",
        //     "Mens-shirts",
        //     "Mens-shoes",
        //     "Mens-watches",
        //     "Womens-watches",
        //     "Womens-bags",
        //     "Womens-jewellery",
        //     "Automotive , Vehicles",
        //     "Motorcycle",
        //     "Apartment",
        //     "Fashion",  /// on we put Fashion
        //     "Sport Dresses"
        // ];