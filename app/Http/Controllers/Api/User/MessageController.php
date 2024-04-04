<?php

namespace App\Http\Controllers\Api\User;

use App\Events\SendMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\MessageResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function storeMessage(Request $request)
    {

        // event(new SendMessage($request->message, $request->username));
        Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        $response = [
            'status' => 'ok',
            'message' => 'Message sent successfully.'
        ];

        return response()->json($response, 201);
    }

    public function removeMessage(Request $request)
    {

        // event(new SendMessage($request->message, $request->username));


        return response()->json($request->all());
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getMessages(Request $request, $chat_user_id)
    {

        $response = [
            'status' => 'ok',
            'chat_user_id' => $chat_user_id,
            'auth_id' => $request->user()->id
        ];

        $auth_user_id = $request->user()->id;

        // $messages = Message::where('sender_id', $id)
        //     ->where('receiver_id', $request->user()->id)
        //     ->orWhere('receiver_id', $request->user()->id)
        //     ->where('sender_id', $id)
        //     ->get();

        $messages = Message::where(function ($query) use ($chat_user_id, $auth_user_id) {
            $query->where('sender_id', $chat_user_id)
                ->where('receiver_id', $auth_user_id);
        })
            ->orWhere(function ($query) use ($chat_user_id, $auth_user_id) {
                $query->where('sender_id', $auth_user_id)
                    ->where('receiver_id', $chat_user_id);
            })
            ->orderBy('created_at')
            ->get();

        $response = [
            'status' => 'ok',
            'data' => MessageResource::collection($messages)
        ];



        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
