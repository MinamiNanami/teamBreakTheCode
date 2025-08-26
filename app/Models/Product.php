<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function kiosk()
    {
        $products = Product::all(); // or with categories
        return view('kiosk', compact('products'));
    }
}
