<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        return Order::with(['orderdetails', 'orderdetails.size', 'orderdetails.size.color', 'orderdetails.size.color.product', 'orderstates'])
            ->where('customer_id', $customer->customer_id)
            ->orderByDesc('order_id')->get();
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

            $cart_to_order = [];
            $cart_remain = [];
            foreach ($cart as $c) {
               if($c->chose) {
                    $cart_to_order[] = $c;
               } else {
                    $cart_remain[] = $c;
               }
            }

            // Failed if the order quantity is greater than the quantity in stock
            foreach ($cart_to_order as $c) {
                $size = Size::findOrFail($c->size_id);
                if($size->quantity < $c->quantity) {
                    return response()->json([
                        'status' => "failed",
                    ]);
                }
            }

            $size_ids = array_column($cart_to_order, 'size_id');

            // Get discount of product
            $products = Size::with(['color', 'color.product'])->whereIn("size_id", $size_ids)->get();
            foreach ($cart_to_order as $c) {
                foreach ($products as $p) {
                    if ($p->size_id == $c->size_id) {
                        $p->quantity = $c->quantity;
                        break;
                    }
                }
            }

            // Calculate total
            $total_price = 0;
            foreach ($products as $p) {
                $total_price += ($p->color->product_price - $p->color->product_price * $p->color->product->product_discount / 100) * $p->quantity;
            }

            // Save order
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

            foreach ($products as $p) {
                $orderdetail = new OrderDetail();
                $orderdetail->product_discount = $p->color->product->product_discount;
                $orderdetail->product_quantity = $p->quantity;
                $orderdetail->price = $p->color->product_price;
                $orderdetail->size_id = $p->size_id;
                $orderdetail->order_id = $order->order_id;
                $orderdetail->save();

                //Update quantity of size
                $size_update = Size::findOrFail($p->size_id);
                $size_update->quantity -= $p->quantity;
                $size_update->save();
            }

            $ONE_MONTH = 60 * 24 * 30;
            return response()->json([
                'order_id' => $order->order_id,
                'status' => "success",
                'message' => 'Order successfully',
            ])->withCookie(cookie('cart', json_encode($cart_remain),$ONE_MONTH));

        } catch (\Exception $error) {
            return response()->json([
                'status' => "failed",
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
        return Order::with(['orderdetails', 'orderdetails.size', 'orderdetails.size.color', 'orderdetails.size.color.product', 'orderstates'])
            ->where('customer_id', $customer->customer_id)
            ->where('order_id', $id)->first();
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
        $customer = $request->user();

        $valid = Order::where('customer_id', $customer->customer_id)
                        ->where('order_id', $id)->first();

        if($valid && ($request->orderstate_name == 3 || $request->orderstate_name == 4)) {
            $order_state = OrderState::firstOrCreate(
            [
                'order_id' => $id,
                'orderstate_name' => $request->orderstate_name,
            ]);

            $order_details = Order::with('orderdetails')->findOrFail($id);

            // Undo quantity
            foreach ($order_details->orderdetails as $od) {
                $size_update = Size::findOrFail($od->size_id);
                $size_update->quantity += $od->product_quantity;
                $size_update->save();
            }

            return OrderState::findOrFail($order_state->orderstate_id);
        }
        return false;
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
