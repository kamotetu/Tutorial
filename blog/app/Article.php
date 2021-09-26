<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title', 'content', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function (self $article) {
            $article->title = 'model_creating';
        });
        self::updating(function (self $article) {
            $article->title = 'model_updating';
        });
    }
}
