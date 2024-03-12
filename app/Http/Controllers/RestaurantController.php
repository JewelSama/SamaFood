<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function getRestaurants()
    {
        try{

            $restaurants = Restaurant::all();

            return response()->json([
                'status' => 'success',
                'data' => $restaurants
            ]);

        } catch(\Throwable $th) {

            throw $th;

            $errors = [
                'error' => [
                    'Something went wrong, please try again.'
                ]
            ];

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, please try again.',
                'errors' => $errors
            ], 500);

        }


    }
}
