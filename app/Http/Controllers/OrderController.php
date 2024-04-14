<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
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
                'data' => $user->order()
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

    public function create(Request $request)
    {

        try {
            
            // Assuming the request body contains the JSON data sent from Postman
            $Items = $request->json()->all();
            $cartItems = $Items['items'];


            
            // You can retrieve the vendor_id from any of the menu item
            $vendorId = $cartItems[0]['vendor_id'];
             // Assuming vendor_id is included in $cartItems

            $user=User::findOrFail(auth()->id());

            $totalPrice = 0;
            $menuIds = [];
            
            foreach($cartItems as $cartItem)
            {
                $totalPrice +=  $cartItem['price'];
                $menuIds[] = $cartItem['menu_id'];
            }

            // Create a new order for the user associated with the vendor
            $order = Order::create([
                'user_id' => $user->id,
                'vendor_id' => $vendorId, 
                'total_price' => $totalPrice, 
                'trx_ref' => $request->trx_ref,
                'delivery_address' => $request->delivery_address,
                'status' => 'pending',
                'menu_ids' => json_encode($menuIds)
            ]);


            foreach($cartItems as $cartItem)
            {
                $totalPrice +=  $cartItem['price'];
                $menu = Menu::findOrFail($cartItem['menu_id']);

                // Create order item
                $order->items()->create([
                    'menu_id' => $cartItem['menu_id'],
                    'quantity' => $cartItem['quantity'],
                    'price' => $menu->price,
                ]);
            }

            
            
    

            return response()->json([
                'status' => 'success',
                'data' => $menuIds,
                // 'pricee' => $totalPrice
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

    public function getVendorOrders(Request $request)
    {
        try{

            $user = auth()->user();

            return response()->json([
                'status' => 'success',
                'data' => $user->orders
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
