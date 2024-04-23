<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Vendor;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getVendorMenu(Request $request, $id)
    {
        try{

            $vendor = Vendor::find($id);

    
            if(!$vendor){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Vendor not found.'
                ], 404);    
            }
            

            return response()->json([
                'status' => 'success',
                'data' => $vendor->menus
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

    public function create(Request $request, $id)
    {

        try {

            $vendor = Vendor::find($id);
    
            if(!$vendor){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Vendor does not exist.'
                ], 404);    
            }

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'price' => ['required', 'string'],
                'display_pic' => ['required', 'image', 'mimes:jpeg,png,jpg,gif|max:2048'],
            ]);    
    
            $menu = Menu::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                "vendor_id" => $id
            ]);
    
            if ($request->hasFile('display_pic')) {
                $image = $request->file('display_pic');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = 'uploads/' . $filename;
                $image->move(public_path('uploads'), $filename);
                $menu->display_pic = $path;
            }
    
            $menu->save();

            return response()->json([
                'status' => 'successs',
                'data' => $vendor->menus
            ], 201);

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

    public function editMenu(Request $request, $id)
    {
        try{

            $menu = Menu::find($id);
    
            if(!$menu){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Menu not found'
                ], 404);    
            }
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'display_pic' => 'string'
            ]);


            // $menu->update([
            //     'name' => $request->name,
            //     'description' => $request->description,
            //     'price' => $request->price,
            // ]);


            // if ($request->hasFile('display_pic')) {
            //     $image = $request->file('display_pic');
            //     $filename = time() . '.' . $image->getClientOriginalExtension();
            //     $path = 'uploads/' . $filename;
            //     $image->move(public_path('uploads'), $filename);
            //     $menu->display_pic = $path;
            // }


            
            // $menu->update($request->all());

            return response()->json([
                'status' => 'success',
                'data' => $menu
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

    public function getAllMenu(){

        try{
            
            $menu = Menu::all();

            return response()->json([
                'status' => 'success',
                'data' => $menu
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
