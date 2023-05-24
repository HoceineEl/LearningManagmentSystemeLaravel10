<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class QaTopic extends Model
{
    protected $fillable = [
        'subject',
        'creator_id',
        'receiver_id',
        'sent_at',
    ];

    protected $casts = [
        'creator_id'  => 'integer',
        'receiver_id' => 'integer',
    ];

    public function messages()
    {
        return $this->hasMany(QaMessage::class, 'topic_id')
            ->orderBy('created_at', 'desc');
    }

    public function hasUnreads()
    {
        return $this->messages()->whereNull('read_at')->where('sender_id', '!=', Auth::user()->id)->exists();
    }

    public function receiverOrCreator()
    {
        return $this->creator_id === Auth::user()->id
        ? User::withTrashed()->find($this->receiver_id)
        : User::withTrashed()->find($this->creator_id);
    }

    public static function unreadCount()
    {
        $topics = self::where(function ($query) {
            $query
                ->where('creator_id', Auth::user()->id)
                ->orWhere('receiver_id', Auth::user()->id);
        })
            ->with('messages')
            ->orderBy('created_at', 'DESC')
            ->get();

        $unreadCount = 0;

        foreach ($topics as $topic) {
            foreach ($topic->messages as $message) {
                if ($message->sender_id !== Auth::user()->id && $message->read_at === null) {
                    $unreadCount++;
                }
            }
        }

        return $unreadCount;
    }
}
