<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Transaction;


class WalletController extends Controller
{
    public function load(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'reference_number' => 'nullable|string',
        ]);

        $user = Auth::user();
        $user->wallet_balance += $request->amount;
        $user->save();

        // Optionally, create a transaction record
        $user->transactions()->create([
            'description' => 'Wallet Load',
            'amount' => $request->amount,
        ]);

        return redirect()->back()->with('success', 'Wallet loaded successfully!');
    }
}
