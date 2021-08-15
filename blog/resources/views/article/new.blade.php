<form action="{{route('article.create')}}" method="post">
    @csrf
    <input name="title" type="text" value="{{old('title')}}">
    <input type="text" name="tag" value="{{old('tag')}}">
    <textarea name="content" cols="30" rows="10">{{old('content')}}</textarea>
    <input type="submit">
</form>

