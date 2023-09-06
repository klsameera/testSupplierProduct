<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiProductController extends Controller
{
    public function products(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $products = Product::where('supplier_id', $request->supplier_id)->get();

        return response()->json([
            'products' => $products,
        ]);
    }

}
