<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function place_order(Request $request){
        if ($request->session()->has('cart')) {
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $address = $request->input('address');
            $city = $request->input('city');
            $cost = $request->session()->get('total_price');
            $status = 'pending';
            $date = date('Y-m-d');
            $cart = $request->session()->get('cart');


           $order_id =  DB::table('orders')->InsertGetId([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'city' => $city,
                'cost' => $cost,
                'date' => $date,
               'status' => $status

            ] , 'id');


            foreach ($cart as $id => $product) {
                $product = $cart[$id];
                $product_id = $product['id'];
                $product_name = $product['name'];
                $product_price = $product['price'];
                $product_image = $product['image'];
                $product_quantity = $product['quantity'];

                DB::table('order_items')->insert([
                    'order_id' => $order_id,
                    'product_id' => $product_id,
                    'product_name' => $product_name,
                    'product_price' => $product_price,
                    'product_image' => $product_image,
                    'product_qty' => $product_quantity,
                    'order_date' => $date
           ]); }
            $request->session()->put('order_id', $order_id);

           return view('payment');


        } else {
            return redirect('/');
        }

    }
}
