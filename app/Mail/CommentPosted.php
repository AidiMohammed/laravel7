<?php

namespace App\Mail;

use App\Comment;
use App\View\Components\comment as ComponentsComment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if($this->comment->user->image)
            $file = storage_path('app/public/').$this->comment->user->image->path;
        else
            $file = storage_path('app/public/users/default/default-avatar.jpg');

        $subject = "comment for {$this->comment->commentable->title}";
        return $this
                ->attach($file,['as' => 'profile_pictuer.jpg','mime' => 'imag/jpeg'])       
                ->subject($subject)
                ->view('emails.posts.comment');
    }
}
