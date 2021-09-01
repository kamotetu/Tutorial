@extends('layouts.app')
@section('content')
    <form action="{{route('article.create')}}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{$id ?? null}}">
        <input name="title" type="text" value="{{old('title', $title ?? null)}}">
        <input type="text" name="tag" value="{{old('tag', $tag ?? null)}}">
        <textarea name="content" cols="30" rows="10">{{old('content', $content ?? null)}}</textarea>
        <input type="submit">
    </form>
@endsection
