<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Recomendation extends Controller
{
    //
    public function recommendBusinesses(Request $request)
    {
        // Get the current logged-in user
        $user = auth()->user();

        // Get the user's interests (assuming they are stored as a JSON array)
        $userInterests = json_decode($user->interests);

        // Query businesses that match the user's interests
        $recommendedBusinesses = Business::whereIn('category', $userInterests)
                                          ->orWhere('location', $user->location)
                                          ->get();

        return view('recommendations.index', compact('recommendedBusinesses'));
    }
}
