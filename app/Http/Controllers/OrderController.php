<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validate
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number'  => 'required|string|max:50',
            'order_method'  => 'required|in:dine-in,take-out',
            'payment_method'=> 'required|in:cash,token',
            'cart'          => 'required',
        ]);

        // Decode cart JSON
        $cart = json_decode($validated['cart'], true);

        // Create order
        $order = Order::create([
            'customer_name'  => $validated['customer_name'],
            'table_number'   => $validated['table_number'],
            'order_method'   => $validated['order_method'],
            'payment_method' => $validated['payment_method'],
            'total'          => collect($cart)->sum(fn($item) => $item['price'] * $item['qty']),
            'cart'           => $cart, // if you use JSON column
        ]);

        return redirect()->route('kiosk')->with('success', 'Order placed successfully!');
    }
}
