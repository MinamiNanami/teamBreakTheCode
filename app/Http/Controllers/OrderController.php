<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'total' => 'required|numeric',
        ]);

        try {
            $order = Order::create([
                'customer_name' => 'Guest',
                'table_number' => null,
                'order_method' => 'kiosk',
                'payment_method' => 'cash',
                'total_price' => $validated['total'],
                'cart' => json_encode($validated['items']),
            ]);

            foreach ($validated['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['qty'],
                ]);
            }

            return response()->json(['message' => 'Order placed successfully!']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
}
