<?php
// ЛР14. Письмо со статистикой за день.

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatMail extends Mailable
{
    use Queueable, SerializesModels;

    public $views;
    public $comments;
    public $articles;

    public function __construct($views, $comments, $articles)
    {
        $this->views = $views;
        $this->comments = $comments;
        $this->articles = $articles;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Статистика сайта за сегодня')
            ->view('mail.stat');
    }
}
