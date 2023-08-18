@extends('layouts.app')
@section('content')

    @foreach ($user->articles as $article)
        <div>
            user_name: {{$user->name}}
        </div>
        <div style="border-bottom: solid 1px gray;">
            <div>
                title: <a href="{{route('article.show', ['id' => $article->id])}}">{{$article->title}}</a>
                <small>{{$article->created_at}}</small>
            </div>
        </div>
    @endforeach
@endsection


