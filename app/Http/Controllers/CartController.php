<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(){
        return view('cart');
    }

    public function add_to_cart(Request $request){
        // if the user has already a cart
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');



            // check if the product is in the cart
            $products_array_ids = array_column($cart , 'id');
            $id = $request->input('id');


            // if it is not in the cart then add it to the cart
            if (!in_array($id, $products_array_ids)) {
                $name = $request->input('name');
                $image = $request->input('image');
                $price = $request->input('price');
                $quantity = $request->input('quantity');
                $sale_price = $request->input('sale_price');

                if ($sale_price != null) {
                    $charge_price = $sale_price;
                }else{
                    $charge_price = $price;
                }


                $products_array = array(
                    'id' => $id,
                    'name' => $name,
                    'price' => $charge_price,
                    'quantity' => $quantity,
                    'image' => $image
                );

                $cart[$id] = $products_array;

                $request->session()->put('cart', $cart);
                $this->CalculateTotalCart($request);
                return view('cart');
            }

            // if the product is already in the cart
            else {
                echo "<script>alert('Product Is Already In The Cart')</script>";
            }

        }
        // if the user do not have a cart
        else {
            $cart = array();
            $id = $request->input('id');
            $name = $request->input('name');
            $price = $request->input('price');
            $quantity = $request->input('quantity');
            $image = $request->input('image');
            $sale_price = $request->input('sale_price');

            if ($sale_price != null) {
                $charge_price = $sale_price;
            }else{
                $charge_price = $price;
            }


            $products_array = array(
                'id' => $id,
                'name' => $name,
                'price' => $charge_price,
                'quantity' => $quantity,
                'image' => $image
            );

            $cart[$id] = $products_array;

            $request->session()->put('cart', $cart);
            $this->CalculateTotalCart($request);
            return view('cart');

        }

    }
    public function CalculateTotalCart(Request $request){
        $cart = $request->session()->get('cart');
        $total_price = 0;
        $total_quantity = 0;
        foreach ($cart as $id => $product) {
            $product = $cart[$id];
            $price = $product['price'];
            $quantity = $product['quantity'];
            $total_price = $total_price + ($price * $quantity);
            $total_quantity = $total_quantity + $quantity;

        }

        $request->session()->put('total_price', $total_price);
        $request->session()->put('total_quantity', $total_quantity);

    }

    public function remove_from_cart(Request $request){

        if ($request->session()->has('cart')){
            $id = $request->input('id');
            $cart = $request->session()->get('cart');
            unset($cart[$id]);
            $request->session()->put('cart', $cart);
            $this->CalculateTotalCart($request);
        }
        return view('cart');

    }

    public function edit_product_quantity(Request $request){



        if ($request->session()->has('cart')){
            $product_id = $request->input('id');
            $product_quantity = $request->input('quantity');


            if ($request->has('decrease_product_quantity_btn')) {
                $product_quantity = $product_quantity - 1;
            }else if ($request->has('increase_product_quantity_btn')){
                $product_quantity = $product_quantity + 1;
            }

            if ($product_quantity <= 0 ) {
                $this->remove_from_cart($request);
            }


            $cart = $request->session()->get('cart');
            if (array_key_exists($product_id,$cart)) {
                $cart[$product_id]['quantity'] = $product_quantity;
                $request->session()->put('cart', $cart);
                $this->CalculateTotalCart($request);
            }

        }
        return view('cart');
    }


}
