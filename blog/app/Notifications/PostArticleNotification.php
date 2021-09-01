<?php

namespace App\Notifications;

use App\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostArticleNotification extends Notification
{
    use Queueable;

    private $article;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        Article $article
    )
    {
        $this->article = $article;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('ブログが新しく投稿されました！|' . config('app.name'))
            ->greeting($this->article->user->name . 'さんがブログを投稿しました！')
            ->line('title: ' . $this->article->title)
            ->action('ブログを見に行く', route('article.show', ['id' => $this->article->id]))
            ->line('アプリをご利用いただきありがとうございます。')
            ->salutation(config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
