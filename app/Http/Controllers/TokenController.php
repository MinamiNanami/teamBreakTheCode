<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\User;

class TokenController extends Controller
{
    public function index() {
        $totalTokens = Token::sum('amount');
        $activeWallets = User::has('wallet')->count();
        $totalTransactions = Token::count();

        return response()->json(compact('totalTokens','activeWallets','totalTransactions'));
    }

    public function mint(Request $request) {
        $request->validate([
            'user_id'=>'required|exists:users,id',
            'amount'=>'required|numeric|min:1'
        ]);

        Token::create([
            'user_id'=>$request->user_id,
            'amount'=>$request->amount,
            'transaction_type'=>'mint'
        ]);

        $request->user()->wallet->increment('balance',$request->amount);

        return response()->json(['message'=>'Tokens minted']);
    }

    public function burn(Request $request) {
        $request->validate([
            'user_id'=>'required|exists:users,id',
            'amount'=>'required|numeric|min:1'
        ]);

        Token::create([
            'user_id'=>$request->user_id,
            'amount'=>$request->amount,
            'transaction_type'=>'burn'
        ]);

        $request->user()->wallet->decrement('balance',$request->amount);

        return response()->json(['message'=>'Tokens burned']);
    }

    public function transfer(Request $request) {
        $request->validate([
            'from_user_id'=>'required|exists:users,id',
            'to_user_id'=>'required|exists:users,id',
            'amount'=>'required|numeric|min:1'
        ]);

        $fromUser = User::findOrFail($request->from_user_id);
        $toUser = User::findOrFail($request->to_user_id);

        if($fromUser->wallet->balance < $request->amount) {
            return response()->json(['error'=>'Insufficient balance'],400);
        }

        Token::create([
            'user_id'=>$fromUser->id,
            'to_user_id'=>$toUser->id,
            'amount'=>$request->amount,
            'transaction_type'=>'transfer'
        ]);

        $fromUser->wallet->decrement('balance',$request->amount);
        $toUser->wallet->increment('balance',$request->amount);

        return response()->json(['message'=>'Tokens transferred']);
    }
}
