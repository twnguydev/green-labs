<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_sender_id',
        'user_receiver_id',
    ];

    public function userSender()
    {
        return $this->belongsTo(User::class, 'user_sender_id');
    }

    public function userReceiver()
    {
        return $this->belongsTo(User::class, 'user_receiver_id');
    }

    public function getMessagesFromSender($senderId)
    {
        return $this->where('user_sender_id', $senderId)->get();
    }

    public function getMessagesFromReceiver($receiverId)
    {
        return $this->where('user_receiver_id', $receiverId)->get();
    }

    public function getMessagesFromSenderAndReceiver($senderId, $receiverId)
    {
        return $this->where('user_sender_id', $senderId)
            ->where('user_receiver_id', $receiverId)
            ->get();
    }
}
