<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;

class ChatMessageController extends Controller
{
    public function sendMessage(Request $request, $firstname, $lastname)
    {
        $userLogged = auth()->user();
        $userTarget = User::where('first_name', ucfirst($firstname))
            ->where('last_name', ucfirst($lastname))
            ->firstOrFail();

        ChatMessage::create([
            'content' => $request->message,
            'user_sender_id' => $userLogged->id,
            'user_receiver_id' => $userTarget->id,
        ]);

        return redirect()->route('chat.user', [
            'firstname' => strtolower($userTarget->first_name),
            'lastname' => strtolower($userTarget->last_name),
        ])->withSuccess('Message envoyé avec succès à ' . $userTarget->first_name . ' ' . $userTarget->last_name);
    }

    public function showChat()
    {
        $userLogged = auth()->user();

        $chatMessages = ChatMessage::where('user_sender_id', $userLogged->id)
            ->orWhere('user_receiver_id', $userLogged->id)
            ->select('user_sender_id', 'user_receiver_id')
            ->get();

        $userIds = $chatMessages->pluck('user_sender_id')->concat($chatMessages->pluck('user_receiver_id'))->unique();

        $uniqueUserIds = $userIds->reject(function ($userId) use ($userLogged) {
            return $userId === $userLogged->id;
        });

        $receiverNames = User::whereIn('id', $uniqueUserIds)
            ->get()
            ->map(function ($user) {
                return $user->first_name . ' ' . $user->last_name;
            });

        return view('chat', [
            'userLogged' => $userLogged,
            'receiverNames' => $receiverNames,
        ]);
    }

    public function showChatWith($firstname, $lastname)
    {
        $userLogged = auth()->user();

        $userReceiver = User::where('first_name', ucfirst($firstname))
            ->where('last_name', ucfirst($lastname))
            ->firstOrFail();

        if ($userLogged->id === $userReceiver->id) {
            return redirect()->route('chat')->withError('Vous ne pouvez pas discuter avec ' . $userReceiver->first_name . ' ' . $userReceiver->last_name);
        }

        $messages = ChatMessage::where(function ($query) use ($userLogged, $userReceiver) {
            $query->where('user_sender_id', $userLogged->id)
                ->where('user_receiver_id', $userReceiver->id);
        })->orWhere(function ($query) use ($userLogged, $userReceiver) {
            $query->where('user_sender_id', $userReceiver->id)
                ->where('user_receiver_id', $userLogged->id);
        })->get();

        $chatMessages = ChatMessage::where('user_sender_id', $userLogged->id)
            ->orWhere('user_receiver_id', $userLogged->id)
            ->select('user_sender_id', 'user_receiver_id')
            ->get();

        $userIds = $chatMessages->pluck('user_sender_id')->concat($chatMessages->pluck('user_receiver_id'))->unique();

        $uniqueUserIds = $userIds->reject(function ($userId) use ($userLogged) {
            return $userId === $userLogged->id;
        });

        $receiverNames = User::whereIn('id', $uniqueUserIds)
            ->get()
            ->map(function ($user) {
                return $user->first_name . ' ' . $user->last_name;
            });

        return view('chat_with', [
            'userReceiver' => $userReceiver,
            'userSender' => $userLogged,
            'receiverNames' => $receiverNames,
            'messages' => $messages,
        ]);
    }
}
