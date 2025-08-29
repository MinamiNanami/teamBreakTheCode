<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoadRequest;

class LoadRequestController extends Controller
{
    public function index() {
        return LoadRequest::with('user')->get();
    }

    public function approve(Request $request, $id) {
        $loadRequest = LoadRequest::findOrFail($id);
        $loadRequest->status = 'approved';
        $loadRequest->notes = $request->notes ?? null;
        $loadRequest->save();

        // Credit user wallet
        $loadRequest->user->wallet->increment('balance', $loadRequest->amount);

        return response()->json(['message' => 'Request approved']);
    }

    public function reject(Request $request, $id) {
        $loadRequest = LoadRequest::findOrFail($id);
        $loadRequest->status = 'rejected';
        $loadRequest->notes = $request->notes ?? null;
        $loadRequest->save();

        return response()->json(['message' => 'Request rejected']);
    }
}
