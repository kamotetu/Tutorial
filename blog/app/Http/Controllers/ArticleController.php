<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PostArticleNotification;
use App\Article;
use App\User;
use Illuminate\Http\Request;
use App\Tag;
use Illuminate\Database\Eloquent;

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
        ],[
            'title.required' => ':attributeは(ﾟ∀ﾟ )おすおす',
        ])->after(function (\Illuminate\Contracts\Validation\Validator $validator) {
            if (empty($validator->failed())) {
                $params = $validator->getData();
                if ($params['title'] !== 'おすおす') {
                    $validator->errors()->add('title', 'おすおすちゃうやん');
                }
            }
        })->setAttributeNames([
            'title' => 'タイトル',
        ]);
        $validator->validate();
        $id = $request->get('id');
        $article = Article::find($id);
        if (isset($article) && $article->user_id !== Auth::user()->id) {
            abort(404);
        }
        $title = $request->get('title');
        $content = $request->get('content');

        if (isset($article)) {
            $article->title = $title;
            $article->content = $content;
            $article->save();
        } else {
            $user_id = Auth::id();
            $article = Article::create(
                [
                    'title' => $title,
                    'content' => $content,
                    'user_id' => $user_id,
                ]
            );
        }

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

        $users = User::where('id', '<>', $article->user->id)->get();
        Notification::send($users, new PostArticleNotification($article));

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

    public function list(Request $request)
    {
        $sort = $request->get('sort');
        if ($sort) {
            if ($sort === '1') {
                $articles = Article::orderBy('created_at')->get();
            } elseif ($sort === '2') {
                $articles = Article::orderBy('created_at', 'DESC')->get();
            } elseif ($sort === '3') {
                $articles = Article::orderBy('title')->get();
            } elseif ($sort === '4') {
                $articles = Article::orderBy('title', 'DESC')->get();
            }
        } else {
            $articles = Article::all();
        }

        return view(
            'article.list',
            [
                'sort' => $sort,
                'articles' => $articles
            ]
        );
    }

    public function search(Request $request)
    {
        $word = $request->get('word');
        if ($word !== null) {
            $escape_word = addcslashes($word, '\\_%');
            $articles = Article::where('title', 'like', '%' . $escape_word . '%')->get();
        } else {
            $articles = Article::all();
        }
        return view(
            'article.list',
            [
                'articles' => $articles
            ]
        );
    }

    public function edit(Request $request)
    {
        $id = $request->route('id');
        $article = Article::find($id);
        if (!isset($article) || $article->user_id !== Auth::id()) {
            abort(404);
        }
        $title = $article->title;
        $content = $article->content;
        $tags = $article->tags->pluck('name')->toArray();
        return view(
            'article.new',
            [
                'id' => $id,
                'title' => $title,
                'content' => $content,
                'tag' => !empty($tags) ? implode(',', $tags) : null,
            ]
        );
    }

    public function delete(Request $request)
    {
        $id = $request->get('id');
        $article = Article::find($id);
        if (!isset($article) || $article->user_id !== Auth::id()) {
            abort(404);
        }
        $article->delete();
        $articles = Article::all();
        return view(
            'article.list',
            [
                'articles' => $articles,
            ]
        );
    }
}
