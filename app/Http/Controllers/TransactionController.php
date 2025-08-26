<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // List user transactions
    public function dashboard()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('wallet', compact('transactions'));
    }

    // Store a new transaction (example)
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'type' => 'required|string',
            'reference_number' => 'nullable|string',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'description' => $request->description,
            'amount' => $request->amount,
            'type' => $request->type,
            'reference_number' => $request->reference_number,
        ]);

        return redirect()->back()->with('success', 'Transaction recorded.');
    }

        public function wallet()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('wallet', compact('transactions'));
    }
}
