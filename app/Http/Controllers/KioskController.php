<?php

namespace App\Http\Controllers;

use App\Models\Product;

class KioskController extends Controller
{
    public function index()
    {
        // only active products
        $products = Product::orderBy('category')
            ->get()
            ->groupBy('category');

        return view('kiosk', compact('products'));
    }
}