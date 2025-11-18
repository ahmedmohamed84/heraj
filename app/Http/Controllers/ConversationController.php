<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function startOrShow(Request $request)
    {
        $request->validate(['service_id' => 'required|exists:services,id']);

        $service = Service::find($request->service_id);

        // User cannot start a conversation with themselves
        if ($service->user_id == Auth::id()) {
            return back()->with('error', 'You cannot start a conversation with yourself.');
        }

        $conversation = Conversation::firstOrCreate(
            [
                'service_id' => $request->service_id,
                'buyer_id' => Auth::id(),
            ],
            [
                'seller_id' => $service->user_id,
            ]
        );

        return redirect()->route('conversations.show', $conversation);
    }

    public function index()
    {
        $user = Auth::user();
        $conversations = Conversation::where('buyer_id', $user->id)
            ->orWhere('seller_id', $user->id)
            ->with(['service', 'buyer', 'seller', 'messages' => function ($query) {
                $query->latest();
            }])
            ->latest()
            ->get();

        return view('conversations.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        // Security: Ensure the user is part of this conversation
        if (Auth::id() !== $conversation->buyer_id && Auth::id() !== $conversation->seller_id) {
            abort(403);
        }

        // Mark messages as read
        $conversation->messages()
            ->where('user_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('conversations.show', compact('conversation'));
    }

    public function getMessagesJson(Request $request, Conversation $conversation)
    {
        // Security: Ensure the user is part of this conversation
        if (Auth::id() !== $conversation->buyer_id && Auth::id() !== $conversation->seller_id) {
            abort(403);
        }

        // Mark incoming messages as read for the current user
        $conversation->messages()
            ->where('user_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $since = $request->query('since');

        $messagesQuery = $conversation->messages()->with('user');

        if ($since && is_numeric($since) && $since > 0) {
            $messagesQuery->where('id', '>', $since);
        }

        $messages = $messagesQuery->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }
}
