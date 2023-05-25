<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public $status;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Post $post, bool $status)
    {
        $this->post = $post;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                ->view('emails.post.update_status')
                ->with([
                    'post' => $this->post,
                    'status' => $this->status
                ]);
    }
}
