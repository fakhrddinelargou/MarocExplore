<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favorites = DB::table('itinerary_user')
                     ->join('itineraries' , 'itineraries.id' , '=' , 'itinerary_user.itinerary_id')
                     ->join('users' , 'users.id' , '=' , 'itinerary_user.user_id')
                     ->where('users.id' , '=' , auth()->id())
                     ->select('itineraries.*')
                     ->get();
        
        return response()->json([
            'data' => $favorites
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id)
    {

        $checkItinerary = DB::table('itineraries')
            ->where('id', $id)->first();

        if (!$checkItinerary) {
            return response()->json(['message' => 'itinerary not found'], 404);
        }
        $store = DB::table('itinerary_user')->insert([
            'user_id' => auth()->id(),
            'itinerary_id' => $id,
        ]);

        if ($store) {
            return response()->json(['message' => 'success'], 201);
        }

        return response()->json(['message' => 'failed'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $row = DB::table('itinerary_user')
               ->where('id' , $id)
               ->delete();
        

        if ($row) {
            return response()->json(['message' => 'success'], 200);
        }

        return response()->json(['message' => 'failed'], 500);

    }
}
