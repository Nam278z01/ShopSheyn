<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Size;

class Cart2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function index2(Request $cart2)
    {
        //
        $cart = json_decode($cart2->getContent());
        for ($i = 0; $i < count($cart); $i++) {
            $product = Product::with(['subcategory', 'colors', 'colors.sizes'])->findOrFail($cart[$i]->product_id);
            $product->size_id = $cart[$i]->size_id;
            $product->quantity = $cart[$i]->quantity;
            $product->cart_id = $cart[$i]->cart_id;
            $product->chose = $cart[$i]->chose;
            $cart[$i] = $product;
        }

        return $cart;
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
        $content = json_decode($request->getContent());

        $cart = $content->cart;

        $product = (object) [
            "product_id" => $content->product->product_id,
            "quantity" => $content->product->quantity,
            "size_id" => $content->product->size_id,
            "cart_id" => $content->product->cart_id,
            "chose" => false,
        ];

        $size = Size::findOrFail($product->size_id);

        if (count($cart) != 0) {
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
        return response()->json(['status' => 'success', 'quantity_in_stock' => $size->quantity, 'cart' => $cart]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $content = json_decode($request->getContent());

        $cart = $content->cart;
        $product = $content->product;

        $size = Size::findOrFail($product->size_id);

        foreach ($cart as $p) {
            if ($p->cart_id == $id) {
                if ($size->quantity < $product->quantity) {
                    return response()->json(['status' => 'greater', 'quantity_in_cart' => $p->quantity, 'quantity_in_stock' => $size->quantity]);
                }

                $p->product_id = $product->product_id;
                $p->size_id = $product->size_id;
                $p->quantity = $product->quantity;
                break;
            }
        }
        return response()->json(['status' => 'success', 'quantity_in_stock' => $size->quantity, 'cart' => $cart]);
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
    }
}
