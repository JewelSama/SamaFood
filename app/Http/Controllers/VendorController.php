<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function getVendors()
    {
        try{

            $vendors = Vendor::select('id', 'name', 'email', 'address', 'display_pic', 'opening_time', 'closing_time', 'description', 'phone_number')->get();

            return response()->json([
                'status' => 'success',
                'data' => $vendors
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
