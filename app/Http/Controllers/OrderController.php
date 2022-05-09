<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Http\Resources\SizeWithColorResource;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderState;
use App\Models\Size;
use Illuminate\Support\Facades\Cookie;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customer = request()->user();
        return OrderResource::collection(Order::where('customer_id', $customer->customer_id)->get());
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
        try {
            $customer = $request->user();
            $cart = json_decode(Cookie::get('cart'));
            $size_ids = array_column($cart, 'size_id');
            $products = SizeWithColorResource::collection(Size::whereIn("size_id", $size_ids)->get());
            $products_to_array = json_decode($products->toJson());
            foreach ($cart as $c) {
                foreach ($products_to_array as $p) {
                    if($p->size_id == $c->size_id){
                        $p->quantity = $c->quantity;
                        break;
                    }
                }
            }
            $total_price = 0;
            foreach ($products_to_array as $p) {
                $total_price += ($p->color->product_price - $p->color->product_price * $p->color->product->product_discount / 100) * $p->quantity;
            }
            $order = new Order();
            $order->customer_name = $request->customer_name;
            $order->customer_address = $request->customer_address;
            $order->customer_phone = $request->customer_phone;
            $order->note = $request->note;
            $order->delivery_cost = 0;
            $order->total = $total_price;
            $order->customer_id = $customer->customer_id;
            $order->save();

            $orderstate = new OrderState();
            $orderstate->order_id = $order->order_id;
            $orderstate->save();

            foreach ($products_to_array as $p) {
                $orderdetail = new OrderDetail();
                $orderdetail->product_discount = $p->color->product->product_discount;
                $orderdetail->product_quantity = $p->quantity;
                $orderdetail->price = $p->color->product_price;
                $orderdetail->size_id = $p->size_id;
                $orderdetail->order_id = $order->order_id;
                $orderdetail->save();
            }

            Cookie::forget('cart');

            return response()->json([
                'status_code' => 200,
                'message' => 'Order successfully',
            ])->withCookie(cookie('cart', json_encode([]), 0));
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error when Order',
                'error' => $error,
            ]);
        }
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
        $customer = request()->user();
        return new OrderResource(Order::where('customer_id', $customer->customer_id)->where('order_id', $id)->first());
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
