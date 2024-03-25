<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use Illuminate\Http\Response;

class TripController extends Controller
{
    public function createTrip(Request $request)
    {

    }

    public function getTrip(int $trip_id)
    {
        // Retrieve the trip associated with the given user_id
        $trip = Trip::where('id', $trip_id)->first();

        if (!$trip) {
            return response()->json([
                'message' => 'Trip not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Trip Found.', 'trip' => $trip], Response::HTTP_OK);
    }

    public function updateTrip(Request $request)
    {

    }

    public function deleteTrip(Request $request)
    {

    }

}
