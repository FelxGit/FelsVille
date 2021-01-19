<?php

namespace App\Http\Controllers\API;

use App\Order;
use App\product;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('carts')->get();
        $data = [];
        foreach($orders as $index => $order) {
            
            $order_only = [
                'user_id' => $order->user_id,
                'shipping_fee' => $order->shipping_fee,
                'cart_total' => $order->cart_total,
                'status' => $order->status,
                'is_delivered' => $order->is_delivered
            ];

            $data[$index] = $order_only;
            $data[$index]['carts'] = $order->carts;

            foreach($data[$index]['carts'] as $i => $cart) {
                $product = Product::find($cart->product_id);
                $data[$index]['carts'][$i]['product'] = $product;
            }
        }
        return response()->json($data,200);
    }

    public function deliverOrder(Order $order)
    {
        $order->is_delivered = true;
        $status = $order->save();

        return response()->json([
            'status'    => $status,
            'data'      => $order,
            'message'   => $status ? 'Order Delivered!' : 'Error Delivering Order'
        ]);
    }

    public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => Auth::id(),
            'shipping_fee' => $request->shipping_fee,
            'cart_total' => $request->cart_total,
            'address' => $request->address
        ]);

        $cart = Auth::user()->carts()->where('status','cart')
        ->update([
            'order_id' => $order->id,
            'status' => 'PENDING'
        ]);
        
        return response()->json([
            'status' => (bool) $order,
            'data'   => $order,
            'message' => $order ? 'Order Created!' : 'Error Creating Order'
        ]);
    }

    public function show(Order $order)
    {
        return response()->json($order,200);
    }

    public function update(Request $request, Order $order)
    {
        $status = $order->update(
            $request->only(['quantity'])
        );

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Order Updated!' : 'Error Updating Order'
        ]);
    }

    public function destroy(Order $order)
    {
        $status = $order->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Order Deleted!' : 'Error Deleting Order'
        ]);
    }
}