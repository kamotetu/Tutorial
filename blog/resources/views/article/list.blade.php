@extends('layouts.app')
@section('content')
    <form action="{{route('article.list.search')}}">
        word: <input type="text" name="word">
        <input type="submit" value="検索">
    </form>
    <form action="{{route('article.list')}}">
        <button type="submit" name="sort" value="@if (!isset($sort) || $sort !== '1') 1 @elseif ($sort === '1') 2 @endif">作成日順</button>
        <button type="submit" name="sort" value="@if (!isset($sort) || $sort !== '3') 3 @elseif ($sort === '3') 4 @endif">あいうえお順</button>
    </form>
    @foreach ($articles as $article)
        <div style="border-bottom: solid 1px gray;">
            <div>
                user: {{$article->user->name}}
            </div>
            <div>
                title: <a href="{{route('article.show', ['id' => $article->id])}}">{{$article->title}}</a>
                <small>{{$article->created_at}}</small>
            </div>
            @if (Auth::check() && Auth::user()->id === $article->user_id)
                <a href="{{route('article.edit', ['id' => $article->id])}}">編集</a>
                <form action="{{route('article.delete')}}" method="post">
                    @csrf
                    <button type="submit" name="id" value="{{$article->id}}">
                        削除
                    </button>
                </form>
            @endif
        </div>
    @endforeach
@endsection


