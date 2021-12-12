<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Messages;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function messages(Request $request)
    {
        $conversations = Conversation::with(['sender', 'messages'])->where('receiver_id', $request->receiver_id)->orWhere('sender_id', $request->receiver_id)->first();
        return response()->json($conversations);
    }
    // public function index()
    // {
    //     $conversations = Conversation::with(['sender', 'messages'])->where('sender_id', auth()->user()->id)->get();
    //     return response()->json($conversations);
    // }

    public function store(Request $request)
    {

        $conversation = Conversation::where('receiver_id', auth()->user()->id)
        ->where('sender_id', $request->receiver_id)
        ->orWhere('receiver_id', $request->receiver_id)->orWhere('sender_id', auth()->user()->id)
        ->first();

        // return response()->json($conversation);
        if(empty($conversation)){
            $conv = Conversation::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $request->receiver_id
            ]);

            Messages::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $request->receiver_id,
                'content' => $request->message,
                'conversation_id' => $conv->id
            ]);
        }
        else {
            Messages::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $request->receiver_id,
                'content' => $request->message,
                'conversation_id' => $conversation->id
            ]);
        }
    }
}
