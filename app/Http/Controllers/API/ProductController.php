<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => $products
        ]);
    }
}