<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Product;
use App\Models\Size;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Cookie::has('cart')) {
            $cart = json_decode(Cookie::get('cart'));
            $product_ids = array_column($cart, 'product_id');

            $products = Product::with(['subcategory', 'colors', 'colors.sizes'])->whereIn("product_id", $product_ids)->get();
            $products_to_array = json_decode($products->toJson());

            $products_in_cart = [];

            foreach ($cart as $c) {
                foreach ($products_to_array as $p) {
                    if($p->product_id == $c->product_id){
                        $pro_new = json_decode(json_encode($p));
                        $pro_new->size_id = $c->size_id;
                        $pro_new->quantity = $c->quantity;
                        $pro_new->cart_id = $c->cart_id;
                        array_push($products_in_cart, $pro_new);
                        break;
                    }
                }
            }

            return $products_in_cart;
        } else {
            return [];
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $product = (object) [
            "product_id" => $request->product_id,
            "quantity" => $request->quantity,
            "size_id" => $request->size_id,
            "cart_id" => $request->cart_id,
        ];

        $size = Size::findOrFail($product->size_id);

        $cart = [];
        if ($request->hasCookie('cart')) {
            $cart = json_decode($request->cookie('cart'));
            $isExists = false;
            foreach ($cart as $p) {
                if ($p->size_id == $product->size_id) {
                    if($p->quantity + $product->quantity > $size->quantity) {
                        return response()->json(['status' => 'greater', 'quantity_in_cart' => $p->quantity, 'quantity_in_stock' => $size->quantity]);
                    }
                    $p->quantity += $product->quantity;
                    $isExists = true;
                    break;
                }
            }
            if (!$isExists) {
                if($product->quantity > $size->quantity) {
                    return response()->json(['status' => 'greater', 'quantity_in_cart' => 0, 'quantity_in_stock' => $size->quantity]);
                }
                array_unshift($cart, $product);
            }
        } else {
            $cart[] = $product;
        }
        $ONE_MONTH = 60 * 24 * 30;
        $cookie = cookie('cart', json_encode($cart), $ONE_MONTH);
        return response()->json(['status' => 'success', 'cart' => $cart])->cookie($cookie);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $cart = json_decode(request()->cookie('cart'));
        $size = Size::findOrFail($request->size_id);

        foreach($cart as $p){
            if($p->cart_id == $id){
                if($size->quantity < $request->quantity) {
                    return response()->json(['status' => 'greater', 'quantity_in_cart' => $p->quantity, 'quantity_in_stock' => $size->quantity]);
                }

                $p->product_id = $request->product_id;
                $p->size_id = $request->size_id;
                $p->quantity = $request->quantity;
                break;
            }
        }
        $cookie = cookie('cart', json_encode($cart), 120);
        return response()->json(['status' => 'success', 'cart' => $cart])->cookie($cookie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $cart = json_decode(request()->cookie('cart'));
        $cart_new = array();
        foreach ($cart as $p) {
            if($p->cart_id != $id) {
                $cart_new[] = $p;
            }
        }
        $cookie = cookie('cart', json_encode($cart_new), 120);
        return response($cart_new)->cookie($cookie);
    }
}
