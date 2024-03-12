<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        return $request->user();
    }

    public function updateProfile(Request $request, $id)
    {
        // return $user;
        
        try{

            $user = User::find($id);
    
            if(!$user){
                return response()->json([
                    'status' => 'failure',
                ], 404);    
            }
            
            $user->update($request->all());

            return response()->json([
                'status' => 'success',
                'user' => $user
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
