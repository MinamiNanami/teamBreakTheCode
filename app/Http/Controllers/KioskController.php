<?php

namespace App\Http\Controllers;

use App\Models\Product;

class KioskController extends Controller
{
    public function index()
    {
        $products = Product::select('id','name','price','category')
            ->orderBy('category')->orderBy('name')->get();

        return view('kiosk', compact('products'));
    }
}