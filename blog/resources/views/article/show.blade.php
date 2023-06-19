@extends('layouts.app')
@section('content')
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

    <svg height="100" width="100" id="svg001">
        <circle cx="50" cy="50" r="40"/>
    </svg>
    <style>
        svg {
            fill: none;
            stroke: lightgreen;
            stroke-width: 20;
            vertical-align: middle;
            stroke-dasharray: calc((40 * 2) * 3.14);
            stroke-dashoffset: 0;
        }
    </style>
@endsection


