<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Destination;
use Illuminate\Support\Facades\DB;


class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('users')
            ->join('itineraries', 'itineraries.user_id', '=', 'users.id')
            ->join('destinations', 'destinations.itinerary_id', '=', 'itineraries.id')
            ->where('users.id', auth()->id())
            ->select('destinations.*')
            ->orderBy('destinations.id', 'asc')
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'There are no destinations for this itinerary'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => ['string ', 'max:225', 'required'],
            'location' => ['string ', 'max:225', 'required'],
            'activities' => ['string ', 'required'],
        ]);

        if (!$data) {
            return response()->json([
                'Error' => 'Data is not valid '
            ]);
        }

        Destination::create([
            'itinerary_id' => $request->itinerary_id,
            'name' => $data['name'],
            'location' => $data['location'],
            'activities' => $data['activities']
        ]);


        return response()->json([
            'status' => 'success'
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('destinations')->where('id', $id)->first();

        if (!$data) {
            return response()->json(['Error' => 'Destination Not Found'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => ['string ', 'max:225', 'required'],
            'location' => ['string ', 'max:225', 'required'],
            'activities' => ['string ', 'required'],
        ]);

        if (!$data) {
            return response()->json([
                'Error' => 'Data is not valid '
            ]);
        }

        $destination = DB::table('destinations')
            ->where('id', $id)
            ->update([
                'name' => $data['name'],
                'location' => $data['location'],
                'activities' => $data['activities'],
            ]);

        if (!$destination) {

            return response()->json(['Error' => 'Destination Not Found'], 404);

        }


        return response()->json(['status' => 'Destination Updated'], 200);



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destination = DB::table('destinations')
            ->where('id', $id)
            ->delete();

        if (!$destination) {

            return response()->json(['Error' => 'Destination Not Found'], 404);

        }

        return response()->json(['status' => 'Destination Deleted'], 200);

    }
}
