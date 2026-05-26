<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Order;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $user = User::first();
        $orders = Order::with('items.product')->where('user_id', $user->id)->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
}