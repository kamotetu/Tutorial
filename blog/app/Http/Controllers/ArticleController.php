<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;//<-追加
use Illuminate\Support\Facades\Auth;
use App\Article;
use Illuminate\Http\Request;
use App\Tag;

class ArticleController extends Controller
{
    public function new ()
    {
        return view('article.new');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                'string',
                'max:25',
            ],
            'content' => [
                'required',
                'string',
                'max:4000',
            ],
            'tag' => [
                'nullable',
                'string',
            ],
        ]);
        if ($validator->fails()) {
            $validator->validate();
        }
        $title = $request->get('title');
        $content = $request->get('content');
        $user_id = Auth::id();
        $article = Article::create(
            [
                'title' => $title,
                'content' => $content,
                'user_id' => $user_id,
            ]
        );

        $input_tag = $request->get('tag');
        if (isset($input_tag)) {
            $tag_ids = [];
            $tags = explode(',', $input_tag);
            foreach ($tags as $tag) {
                $tag = Tag::updateOrCreate(
                    [
                        'name' => $tag,
                    ]
                );
                $tag_ids[] = $tag->id;
            }
            $article->tags()->sync($tag_ids);
        }

        return redirect()->route('article.show', ['id' => $article->id]);
    }

    public function show(Request $request)
    {
        $id = $request->route('id');
        $article = Article::find($id);
        if (!isset($article)) {
            abort(404);
        }
        return view(
            'article.show',
            [
                'article' => $article,
            ]
        );
    }
}
