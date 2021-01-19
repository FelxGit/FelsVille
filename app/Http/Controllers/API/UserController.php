<?php

namespace App\Http\Controllers\API;

use Auth;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Cart;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::with(['orders'])->get());
    }

    public function login(Request $request)
    {
        $status = 401;
        $response = ['error' => 'Unauthorised'];

        if (Auth::attempt($request->only(['email', 'password']))) {
            $this->pullLocalCart();

            $status = 200;
            $response = [
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('felStore')->accessToken,
            ];
        }

        return response()->json($response, $status);
    }
    private function pullLocalCart(){
        $local_cart = Cache::has('cart')? json_decode(Cache::get('cart')) : []; 

        $data = [];
        foreach($local_cart as $cart){
            $array = (array) $cart; //{ } is typecasted converted to associative array
            $array['user_id'] = Auth::user()->id;
            array_push($data, $array);
        }
        
        Cart::insert($data);
        Cache::forget('cart');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('felStore')->accessToken,
        ]);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function showOrders(User $user)
    {   
        return response()->json($user->orders()->with(['products'])->get(),200);
    }

}