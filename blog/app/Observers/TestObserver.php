<?php

namespace App\Observers;

use App\Article;
use Illuminate\Support\Facades\Log;

class TestObserver
{
    public function creating(Article $article)
    {
        $article->title = 'creating!';
    }

    public function updating(Article $article)
    {
        $article->title = 'updating!';
    }
}
