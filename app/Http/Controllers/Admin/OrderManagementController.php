<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderState;
use App\Models\Size;

class OrderManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Order::with(['orderdetails', 'orderdetails.size', 'orderdetails.size.color', 'orderdetails.size.color.product', 'orderstates'])
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
        return Order::with(['orderdetails', 'orderdetails.size', 'orderdetails.size.color', 'orderdetails.size.color.product', 'orderstates'])
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
        $order_state = OrderState::firstOrCreate(
            [
                'order_id' => $id,
                'orderstate_name' => $request->orderstate_name,
            ]);

            $order_details = Order::with('orderdetails')->findOrFail($id);

            // Undo quantity
            if($request->orderstate_name == 3 || $request->orderstate_name == 4) {
                foreach ($order_details->orderdetails as $od) {
                    $size_update = Size::findOrFail($od->size_id);
                    $size_update->quantity += $od->product_quantity;
                    $size_update->save();
                }
            }

            if(!$order_state->orderstate_date) {
                return OrderState::findOrFail($order_state->orderstate_id);
            } else {
                return false;
            }
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
