<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Itinerary;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\returnArgument;


class ItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('itineraries')
            ->join('destinations', 'destinations.itinerary_id', '=', 'itineraries.id')
            ->where('itineraries.user_id', auth()->id())
            ->select('itineraries.*', 'destinations.name as dest_name', 'destinations.location')
            ->get()
            ->groupBy('id');

        // dd($itineraries);
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
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:225'],
            'duration' => ['required', 'string', 'max:100'],
        ]);

        if (!$data) {
            return response()->json(['Error' => 'Data Not Valid']);
        }

        Itinerary::create([
            'title' => $data['title'],
            'category' => $data['category'],
            'duration' => $data['duration'],
            'image' => $request['image'],
            'user_id' => $request['user_id']
        ]);

        return response()->json([
            'success' => 'creation success'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('itineraries')->where('id', $id)->where('user_id', auth()->id())->first();

        if (!empty($data)) {
            return response()->json([
                'data' => $data,
            ], 200);
        }

        return response()->json([
            'Error' => 'itinerary Not Found',
        ], 404);

    }

    public function getItineraryByCategory(string $category)
    {

        $data = DB::table('itineraries')
            ->where('category', $category)
            ->where('user_id', auth()->id())
            ->get();
        if ($data->isEmpty()) {
            return response()->json(['Error' => 'itinerary is not found']);
        }


        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);

    }


    public function search(Request $request)
    {

        $data = DB::table('itineraries')
            ->where('title', 'ilike', '%' . $request->keyword . '%')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'asc')
            ->get();


        if ($data->isEmpty()) {
            return response()->json(['Error' => 'Not Found'], 404);
        }

        return response()->json([
            'stutas' => 'success',
            'data' => $data
        ]);

        // return  "true";

    }

    // public function populerItineraries(){

    // $data = DB::

    // }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:225'],
            'duration' => ['required', 'string', 'max:100'],
        ]);

        if (!$data) {
            return response()->json(['Error' => 'Data InValid']);
        }

        $itinerary = DB::table('itineraries')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->update([
                'title' => $data['title'],
                'category' => $data['category'],
                'duration' => $data['duration'],
                'image' => $request['image'],
            ]);

        return response()->json(['success' => 'update success']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = DB::table('itineraries')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        if ($deleted) {
            return response()->json(['success' => 'delete success']);
        }



        return response()->json(['Error' => 'Itinerary not found or unauthorized'], 404);

    }
}
