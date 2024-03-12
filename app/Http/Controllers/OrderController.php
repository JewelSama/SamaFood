<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getUserOrders(Request $request, $id)
    {
        try{

            $user = User::find($id);
    
            if(!$user){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User not found'
                ], 404);    
            }
            

            return response()->json([
                'status' => 'success',
                'orders' => $user->order()
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
