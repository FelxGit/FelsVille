<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use App\Cart;
use App\Product;
use Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Auth::user()->cart()->where('status','cart')->with('product')->get());
    }
    
    public function localIndex()
    {
        $data = [];
        $cart = Cache::has('cart')? json_decode(Cache::get('cart')) : [];
        foreach($cart as $c){
            $product = Product::find($c->product_id)->toArray(); // convert a collection - eloquent toArray()
            $cartArray = [ 'quantity' => $c->quantity ];
            $cartArray['product'] = $product;
            array_push($data, $cartArray);
        }
        return response()->json($data);
    }
    

    public function store(Request $request) {
        
        $cart = new Cart;
        $cart->user_id = Auth::user()->id;
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json($cart);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function localStore($product_id, $quantity)
    {
        
        $cart = Cache::has('cart')? json_decode(Cache::get('cart')) : [];
        $data = [
            'product_id' => $product_id,
            'quantity' => $quantity 
        ];    
        
        array_push($cart,$data);
        Cache::put('cart', json_encode($cart)); //reput
        return response()->json($cart);
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
    public function update(Request $request, Cart $cart)
    {
        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json(Auth::user()->cart()->with('product')->get());
    }

    public function localUpdate(Request $request, $index)
    {
        $cart = json_decode(Cache::get('cart'));
        $cart[$index]->quantity = $request->quantity;
        Cache::put('cart', json_encode($cart));
        
        $data = [];
        $cart = json_decode(Cache::get('cart'));

        foreach($cart as $c){
            
            $cartArray = [ 
                'product_id' => $c->product_id,
                'quantity' => $c->quantity
             ];

            $product = Product::find($c->product_id)->toArray(); // convert a collection - eloquent toArray()
            $cartArray['product'] = $product;
            array_push($data, $cartArray);
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return response()->json(Auth::user()->cart()->with('product')->get());
    }

    public function localDestroy($index)
    {
        $cart = json_decode(Cache::get('cart'));
        array_splice($cart,$index,1);
        Cache::put('cart',json_encode($cart));

        $data = [];
        $cart = Cache::has('cart')? json_decode(Cache::get('cart')) : [];
        foreach($cart as $c){
            
            $cartArray = [ 
                'product_id' => $c->product_id,
                'quantity' => $c->quantity
             ];

            $product = Product::find($c->product_id)->toArray(); // convert a collection - eloquent toArray()
            $cartArray['product'] = $product;
            array_push($data, $cartArray);
        }

        return response()->json($data);
   }
}
