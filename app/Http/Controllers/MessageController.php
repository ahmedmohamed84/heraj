<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'body' => 'required|string',
        ]);

        $conversation = Conversation::find($request->conversation_id);

        // Security: Ensure the user is part of this conversation
        if (Auth::id() !== $conversation->buyer_id && Auth::id() !== $conversation->seller_id) {
            abort(403);
        }

        Message::create([
            'conversation_id' => $request->conversation_id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return back();
    }

    public function storeJson(Request $request, Conversation $conversation)
    {
        // Security: Ensure the user is part of this conversation
        if (Auth::id() !== $conversation->buyer_id && Auth::id() !== $conversation->seller_id) {
            abort(403, 'You are not part of this conversation.');
        }

        $request->validate([
            'body' => 'required|string',
        ]);

        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        // Eager load the user relationship so it's included in the JSON response
        $message->load('user');

        return response()->json($message);
    }
}
