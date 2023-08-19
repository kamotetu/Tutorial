@extends('layouts.app')
@section('content')
    <form action="{{route('article.create')}}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{$id ?? null}}">
        <div class="form-row">
            <div class="form-group col-sm-6">
                <label>Title</label>
                <input
                    name="title"
                    type="text"
                    value="{{old('title', $title ?? null)}}"
                    class="form-control
                    @error ('title') is-invalid @enderror"
                >
                @error('title')
                    <ul class="invalid-feedback">
                        @foreach ($errors->get('title') as $message)
                            <li>
                                {{$message}}
                            </li>
                        @endforeach
                    </ul>
                @enderror
            </div>
            <div class="form-group col-sm-6">
                <label>Tag</label>
                <input
                    type="text"
                    name="tag"
                    value="{{old('tag', $tag ?? null)}}"
                    class="form-control @error ('tag') is-invalid @enderror"
                    placeholder="separated by ,"
                >
                @error('tag')
                    <ul class="invalid-feedback">
                        @foreach ($errors->get('tag') as $message)
                            <li>
                                {{$message}}
                            </li>
                        @endforeach
                    </ul>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-sm-6">
                <label>Content</label>
                <textarea
                    name="content"
                    cols="30"
                    rows="10"
                    class="form-control @error ('content') is-invalid @enderror"
                >{{old('content', $content ?? null)}}</textarea>
                @error('content')
                    <ul class="invalid-feedback">
                        @foreach ($errors->get('content') as $message)
                            <li>
                                {{$message}}
                            </li>
                        @endforeach
                    </ul>
                @enderror
            </div>
            <div class="form-group col-sm-6 d-flex align-items-end">
                <input type="submit" class="btn btn-primary">
            </div>
        </div>
    </form>
@endsection
