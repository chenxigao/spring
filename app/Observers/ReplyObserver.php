<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $topic = $reply->topic;
        $topic->increment('reply_count', 1);

        //通知作者话题回复了
        $topic->user->notify(new TopicReplied($reply));
    }

    public function creating(Reply $reply)
    {
        //XSS过滤
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function deleted(Reply $reply)
    {
        //减去话题回复数
        $reply->topic->decrement('reply_count', 1);
    }
}