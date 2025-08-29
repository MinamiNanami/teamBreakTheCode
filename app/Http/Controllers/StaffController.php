<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item; // Make sure this model exists and matches your items table
use App\Models\OrderItem;
use App\Models\Product;

class StaffController extends Controller
{
    public function index()
    {
        $items = Product::all(); // Fetch all items from database
        return view('staff', compact('items')); // Pass $items to Blade
    }
}
