<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
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
        if (Cookie::has('cart')) {
            $cart = json_decode(Cookie::get('cart'));

            for ($i = 0; $i < count($cart); $i++) {
                $product = Product::with(['subcategory', 'colors', 'colors.sizes'])->findOrFail($cart[$i]->product_id);
                $product->size_id = $cart[$i]->size_id;
                $product->quantity = $cart[$i]->quantity;
                $product->cart_id = $cart[$i]->cart_id;
                $product->chose = $cart[$i]->chose;
                $cart[$i] = $product;
            }

            return $cart;
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
            "chose" => false,
        ];

        $size = Size::findOrFail($product->size_id);

        $cart = [];
        if ($request->hasCookie('cart')) {
            $cart = json_decode($request->cookie('cart'));
            $isExists = false;
            foreach ($cart as $p) {
                if ($p->size_id == $product->size_id) {
                    if ($p->quantity + $product->quantity > $size->quantity) {
                        return response()->json(['status' => 'greater', 'quantity_in_cart' => $p->quantity, 'quantity_in_stock' => $size->quantity]);
                    }
                    $p->quantity += $product->quantity;
                    $isExists = true;
                    break;
                }
            }
            if (!$isExists) {
                if ($product->quantity > $size->quantity) {
                    return response()->json(['status' => 'greater', 'quantity_in_cart' => 0, 'quantity_in_stock' => $size->quantity]);
                }
                array_unshift($cart, $product);
            }
        } else {
            $cart[] = $product;
        }
        $ONE_MONTH = 60 * 24 * 30;
        $cookie = cookie('cart', json_encode($cart), $ONE_MONTH);
        return response()->json(['status' => 'success', 'quantity_in_stock' => $size->quantity, 'cart' => $cart])->cookie($cookie);
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

        foreach ($cart as $p) {
            if ($p->cart_id == $id) {
                if ($size->quantity < $request->quantity) {
                    return response()->json(['status' => 'greater', 'quantity_in_cart' => $p->quantity, 'quantity_in_stock' => $size->quantity]);
                }

                $p->product_id = $request->product_id;
                $p->size_id = $request->size_id;
                $p->quantity = $request->quantity;
                break;
            }
        }
        $ONE_MONTH = 60 * 24 * 30;
        $cookie = cookie('cart', json_encode($cart), $ONE_MONTH);
        return response()->json(['status' => 'success', 'quantity_in_stock' => $size->quantity, 'cart' => $cart])->cookie($cookie);
    }

    public function choseAll(Request $request)
    {
        $cart = json_decode(request()->cookie('cart'));

        foreach ($cart as $p) {
            $p->chose = $request->value;
        }
        $ONE_MONTH = 60 * 24 * 30;
        $cookie = cookie('cart', json_encode($cart), $ONE_MONTH);
        return response()->json(['status' => 'success', 'cart' => $cart])->cookie($cookie);
    }

    public function chose(Request $request)
    {
        $cart = json_decode(request()->cookie('cart'));

        foreach ($cart as $p) {
            if ($p->cart_id == $request->cart_id) {
                $p->chose = $request->value;
                break;
            }
        }
        $ONE_MONTH = 60 * 24 * 30;
        $cookie = cookie('cart', json_encode($cart), $ONE_MONTH);
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
            if ($p->cart_id != $id) {
                $cart_new[] = $p;
            }
        }
        $ONE_MONTH = 60 * 24 * 30;
        $cookie = cookie('cart', json_encode($cart_new), $ONE_MONTH);
        return response($cart_new)->cookie($cookie);
    }
}
