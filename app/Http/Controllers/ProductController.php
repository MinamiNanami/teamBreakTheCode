<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Store a new product (from kiosk modal).
     */
    public function store(Request $request)
    {
        // ✅ Validate inputs
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // optional image
        ]);

        // ✅ Handle image upload if provided
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // ✅ Save product
        Product::create($validated);

        // ✅ Redirect back to kiosk with success message
        return redirect()->back()->with('success', 'Product added successfully!');
    }
}
