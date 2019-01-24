<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic)
    {
        // Xss 过滤
        $topic->body = clean($topic->body,'user_topic_body');
        // 摘要
        $topic->excerpt = make_excerpt($topic->body);

        // 如 slug 字段无内容，就用翻译器对 title 翻译
        if(!$topic->slug){
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }
}
