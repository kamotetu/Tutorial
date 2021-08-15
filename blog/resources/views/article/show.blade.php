投稿者: {{$article->user->name}}
<br>
title: {{$article->title}}
<br>
tag:
@if ($article->tags()->exists())
    @foreach ($article->tags as $tag)
        <span style="margin-left: 5px;">{{$tag->name}}</span>
    @endforeach
@else
    タグの登録はありません。
@endif
<br>
内容:
<br>
{!!nl2br(e($article->content))!!}
