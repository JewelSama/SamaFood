<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getRestaurantMenu(Request $request, $id)
    {
        try{

            $restaurant = Restaurant::find($id);
    
            if(!$restaurant){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Restaurant not found.'
                ], 404);    
            }
            

            return response()->json([
                'status' => 'success',
                'data' => $restaurant->menu()
            ], 200);

        } catch (\Throwable $th) {

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
