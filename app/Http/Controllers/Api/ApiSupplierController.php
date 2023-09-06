<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiSupplierController extends Controller
{
    public function suppliers()
    {
        $suppliers = Supplier::all();

        return response()->json([
            'suppliers' => $suppliers,
        ]);
    }
}
