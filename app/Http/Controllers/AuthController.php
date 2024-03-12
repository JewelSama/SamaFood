<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User 
     */
    public function register(Request $request)
    {   
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'lowercase', 'unique:'.User::class],
            'password' => 'required|confirmed|min:6',
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string', 'max:255'],
        ]);

        try {

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'phone_number' => $request->phone_number,
            ]);

            $token = $user->createToken('Sama Food');

            return response()->json([
                'status' => 'success',
                'token' => $token->plainTextToken,
                'user' => $user
            ], 201);

        } catch(\Throwable $th){

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

    public function login(Request $request)
    {
        
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'lowercase'],
            'password' => ['required', 'string', 'max:255']
        ]);

        $user = User::where('email', $request->email)->first();
        
        if(! $user || ! Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }
        
        $user->save();
        
        $token = $user->createToken('Sama Food');

        return response()->json([
            'status'=> 'success',
            'token' => $token->plainTextToken,
            'user' => $user
        ], 200);

    }
}
